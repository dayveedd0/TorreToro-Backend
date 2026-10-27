<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeduplicateStorageMedia extends Command
{
    protected $signature = 'media:deduplicate {--dry-run : Only display duplicate files and planned replacements without deleting}';
    protected $description = 'Find and remove duplicate media files from storage/app/public while updating all database references';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $this->info($isDryRun ? '--- RUNNING IN DRY-RUN MODE (No files will be deleted) ---' : '--- RUNNING LIVE DEDUPLICATION ---');

        $disk = Storage::disk('public');
        $storageRoot = str_replace('\\', '/', storage_path('app/public'));

        if (!File::isDirectory($storageRoot)) {
            $this->error("Storage path {$storageRoot} does not exist.");
            return 1;
        }

        $allFiles = File::allFiles($storageRoot);
        $this->info("Scanning " . count($allFiles) . " total files in storage...");

        $hashMap = [];
        foreach ($allFiles as $file) {
            $realPath = str_replace('\\', '/', $file->getRealPath());
            $hash = hash_file('sha256', $realPath);
            $relPath = ltrim(Str::replaceFirst($storageRoot, '', $realPath), '/');

            $hashMap[$hash][] = [
                'fullPath' => $realPath,
                'relPath' => $relPath,
                'url' => '/storage/' . $relPath,
                'size' => $file->getSize(),
                'name' => $file->getFilename(),
            ];
        }

        $duplicateGroups = array_filter($hashMap, fn($group) => count($group) > 1);
        $totalGroups = count($duplicateGroups);
        $totalRedundantFiles = array_sum(array_map(fn($g) => count($g) - 1, $duplicateGroups));

        $this->line("Found <fg=yellow>{$totalGroups}</> duplicate groups containing <fg=red>{$totalRedundantFiles}</> redundant files.\n");

        if ($totalGroups === 0) {
            $this->info("No duplicate files found in storage!");
            return 0;
        }

        $totalFreedBytes = 0;
        $totalDbUpdates = 0;

        foreach ($duplicateGroups as $hash => $files) {
            // Pick canonical file: prefer semantic folders over uploads/library, and prefer clean filenames without '- Copy' or '__1_'
            usort($files, function ($a, $b) {
                $priority = [
                    'uploads/branding/' => 10,
                    'uploads/hero/' => 9,
                    'uploads/about/' => 8,
                    'uploads/services/' => 7,
                    'uploads/projects/' => 6,
                    'uploads/testimonials/' => 5,
                    'uploads/team/' => 5,
                    'uploads/maps/' => 5,
                    'uploads/video/' => 5,
                    'uploads/posts/' => 4,
                    'uploads/library/' => 1,
                    'uploads/' => 2,
                ];

                $aScore = 0;
                $bScore = 0;
                foreach ($priority as $folder => $score) {
                    if (str_starts_with($a['relPath'], $folder)) $aScore = max($aScore, $score);
                    if (str_starts_with($b['relPath'], $folder)) $bScore = max($bScore, $score);
                }

                // Penalize copy or duplicate name patterns
                if (preg_match('/(copy|__1_|\(\d+\))/i', $a['name'])) $aScore -= 5;
                if (preg_match('/(copy|__1_|\(\d+\))/i', $b['name'])) $bScore -= 5;

                if ($aScore !== $bScore) {
                    return $bScore <=> $aScore; // higher score first
                }

                // If same score, prefer shorter cleaner path
                return strlen($a['relPath']) <=> strlen($b['relPath']);
            });

            $canonical = $files[0];
            $duplicates = array_slice($files, 1);

            $this->line("<fg=green>KEEP CANONICAL:</> {$canonical['url']} (" . round($canonical['size'] / 1024, 1) . " KB)");

            foreach ($duplicates as $dupe) {
                $totalFreedBytes += $dupe['size'];
                $this->line("  <fg=red>REMOVE DUPLICATE:</> {$dupe['url']}");

                // Remap references in DB
                $dbChanges = $this->remapDatabaseReferences($dupe['url'], $canonical['url'], $isDryRun);
                $totalDbUpdates += $dbChanges;

                if (!$isDryRun) {
                    if ($disk->exists($dupe['relPath'])) {
                        $disk->delete($dupe['relPath']);
                    }
                }
            }
            $this->line("");
        }

        $freedMb = round($totalFreedBytes / (1024 * 1024), 2);
        $this->info("=========================================");
        $this->info("Deduplication Summary:");
        $this->info("- Redundant files handled: {$totalRedundantFiles}");
        $this->info("- Storage space saved: {$freedMb} MB");
        $this->info("- Database references updated: {$totalDbUpdates}");
        $this->info("=========================================");

        return 0;
    }

    private function remapDatabaseReferences(string $oldUrl, string $newUrl, bool $isDryRun): int
    {
        $updatedCount = 0;
        $variants = [
            $oldUrl => $newUrl,
            ltrim($oldUrl, '/') => ltrim($newUrl, '/'),
            Str::after($oldUrl, '/storage/') => Str::after($newUrl, '/storage/'),
        ];

        // 1. Settings
        $settings = Setting::all();
        foreach ($settings as $setting) {
            if ($setting->value) {
                foreach ($variants as $oldV => $newV) {
                    if (str_contains($setting->value, $oldV)) {
                        $updatedCount++;
                        if (!$isDryRun) {
                            $setting->value = str_replace($oldV, $newV, $setting->value);
                            $setting->save();
                        }
                        $this->comment("    -> Updated Setting [{$setting->key}]");
                        break;
                    }
                }
            }
        }

        // 2. Pages (hero_image, content, sections JSON)
        $pages = Page::all();
        foreach ($pages as $page) {
            $changed = false;
            foreach ($variants as $oldV => $newV) {
                if ($page->hero_image && str_contains($page->hero_image, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $page->hero_image = str_replace($oldV, $newV, $page->hero_image);
                }
                if ($page->content && str_contains($page->content, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $page->content = str_replace($oldV, $newV, $page->content);
                }
                if (!empty($page->sections)) {
                    $json = json_encode($page->sections);
                    if (str_contains($json, $oldV)) {
                        $changed = true;
                        if (!$isDryRun) {
                            $json = str_replace($oldV, $newV, $json);
                            $page->sections = json_decode($json, true);
                        }
                    }
                }
            }
            if ($changed) {
                $updatedCount++;
                if (!$isDryRun) $page->save();
                $this->comment("    -> Updated Page [{$page->slug}]");
            }
        }

        // 3. Projects (thumbnail_image, banner_image, gallery_images JSON, description)
        $projects = Project::all();
        foreach ($projects as $project) {
            $changed = false;
            foreach ($variants as $oldV => $newV) {
                if ($project->thumbnail_image && str_contains($project->thumbnail_image, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $project->thumbnail_image = str_replace($oldV, $newV, $project->thumbnail_image);
                }
                if ($project->banner_image && str_contains($project->banner_image, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $project->banner_image = str_replace($oldV, $newV, $project->banner_image);
                }
                if ($project->description && str_contains($project->description, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $project->description = str_replace($oldV, $newV, $project->description);
                }
                if (!empty($project->gallery_images)) {
                    $json = json_encode($project->gallery_images);
                    if (str_contains($json, $oldV)) {
                        $changed = true;
                        if (!$isDryRun) {
                            $json = str_replace($oldV, $newV, $json);
                            $project->gallery_images = json_decode($json, true);
                        }
                    }
                }
            }
            if ($changed) {
                $updatedCount++;
                if (!$isDryRun) $project->save();
                $this->comment("    -> Updated Project [{$project->slug}]");
            }
        }

        // 4. Services (thumbnail_image, banner_image, gallery_images JSON, description)
        $services = Service::all();
        foreach ($services as $service) {
            $changed = false;
            foreach ($variants as $oldV => $newV) {
                if ($service->thumbnail_image && str_contains($service->thumbnail_image, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $service->thumbnail_image = str_replace($oldV, $newV, $service->thumbnail_image);
                }
                if ($service->banner_image && str_contains($service->banner_image, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $service->banner_image = str_replace($oldV, $newV, $service->banner_image);
                }
                if ($service->description && str_contains($service->description, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $service->description = str_replace($oldV, $newV, $service->description);
                }
                if (!empty($service->gallery_images)) {
                    $json = json_encode($service->gallery_images);
                    if (str_contains($json, $oldV)) {
                        $changed = true;
                        if (!$isDryRun) {
                            $json = str_replace($oldV, $newV, $json);
                            $service->gallery_images = json_decode($json, true);
                        }
                    }
                }
            }
            if ($changed) {
                $updatedCount++;
                if (!$isDryRun) $service->save();
                $this->comment("    -> Updated Service [{$service->slug}]");
            }
        }

        // 5. Posts (featured_image, content)
        $posts = Post::all();
        foreach ($posts as $post) {
            $changed = false;
            foreach ($variants as $oldV => $newV) {
                if ($post->featured_image && str_contains($post->featured_image, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $post->featured_image = str_replace($oldV, $newV, $post->featured_image);
                }
                if ($post->content && str_contains($post->content, $oldV)) {
                    $changed = true;
                    if (!$isDryRun) $post->content = str_replace($oldV, $newV, $post->content);
                }
            }
            if ($changed) {
                $updatedCount++;
                if (!$isDryRun) $post->save();
                $this->comment("    -> Updated Post [{$post->slug}]");
            }
        }

        // 6. Testimonials (avatar_image)
        $testimonials = Testimonial::all();
        foreach ($testimonials as $testimonial) {
            foreach ($variants as $oldV => $newV) {
                if ($testimonial->avatar_image && str_contains($testimonial->avatar_image, $oldV)) {
                    $updatedCount++;
                    if (!$isDryRun) {
                        $testimonial->avatar_image = str_replace($oldV, $newV, $testimonial->avatar_image);
                        $testimonial->save();
                    }
                    $this->comment("    -> Updated Testimonial [{$testimonial->client_name}]");
                    break;
                }
            }
        }

        return $updatedCount;
    }
}
