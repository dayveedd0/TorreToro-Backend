<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectGalleryTest extends TestCase
{
    use RefreshDatabase;

    protected Domain $domain;
    protected User $admin;
    protected ProjectCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->domain = Domain::where('code', 'global')->first();
        $this->admin = User::where('email', 'admin@torretoro.com')->first();
        $this->category = ProjectCategory::firstOrCreate(['name' => 'Commercial Interiors', 'slug' => 'commercial-interiors']);
    }

    public function test_admin_can_view_project_create_form_with_gallery_section(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.projects.create'));

        $response->assertStatus(200);
        $response->assertSee('Project Photography Gallery', false);
        $response->assertSee('Upload multiple photos directly', false);
        $response->assertSee('Choose Multiple from Library', false);
        $response->assertSee('Insert Selected', false);
        $response->assertSee('Multi-Select Mode', false);
    }

    public function test_admin_can_create_project_with_gallery_items_and_captions(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.projects.store'), [
                'title' => 'Nova Towers Executive Penthouse',
                'slug' => 'nova-towers-penthouse',
                'category_id' => $this->category->id,
                'client_name' => 'Nova Capital',
                'location' => 'Victoria Island, Lagos',
                'year' => '2024',
                'services_rendered' => 'Turnkey Fit-Out',
                'thumbnail_image' => '/storage/uploads/projects/nova-cover.jpg',
                'banner_image' => '/storage/uploads/projects/nova-banner.jpg',
                'gallery_items' => [
                    [
                        'url' => '/storage/uploads/projects/nova-1.jpg',
                        'caption' => 'Executive Boardroom',
                    ],
                    [
                        'url' => '/storage/uploads/projects/nova-2.jpg',
                        'caption' => 'Private Client Lounge',
                    ],
                ],
                'stats_area' => '10,000 sq ft',
                'stats_timeline' => '12 weeks',
                'is_featured' => '1',
                'order' => 1,
            ]);

        $response->assertRedirect(route('admin.projects.index'));

        $project = Project::where('slug', 'nova-towers-penthouse')->first();
        $this->assertNotNull($project);
        $this->assertEquals('/storage/uploads/projects/nova-cover.jpg', $project->thumbnail_image);
        $this->assertEquals('/storage/uploads/projects/nova-banner.jpg', $project->banner_image);
        $this->assertCount(2, $project->gallery_images);
        $this->assertEquals('/storage/uploads/projects/nova-1.jpg', $project->gallery_images[0]['url']);
        $this->assertEquals('Executive Boardroom', $project->gallery_images[0]['caption']);
        $this->assertEquals(['/storage/uploads/projects/nova-1.jpg', '/storage/uploads/projects/nova-2.jpg'], $project->gallery_urls);
    }

    public function test_admin_can_create_project_with_multiple_uploaded_gallery_files(): void
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->create('office1.jpg', 100, 'image/jpeg');
        $file2 = UploadedFile::fake()->create('office2.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.projects.store'), [
                'title' => 'Apex Financial Hub',
                'slug' => 'apex-financial-hub',
                'category_id' => $this->category->id,
                'gallery_files' => [$file1, $file2],
            ]);

        $response->assertRedirect(route('admin.projects.index'));

        $project = Project::where('slug', 'apex-financial-hub')->first();
        $this->assertNotNull($project);
        $this->assertCount(2, $project->gallery_images);
        $this->assertStringStartsWith('/storage/uploads/projects/', $project->gallery_images[0]['url']);
        $this->assertStringStartsWith('/storage/uploads/projects/', $project->gallery_images[1]['url']);
    }

    public function test_admin_can_update_project_gallery_reorder_and_remove_items(): void
    {
        $project = Project::create([
            'domain_id' => $this->domain->id,
            'category_id' => $this->category->id,
            'title' => 'Orion Tech Suites',
            'slug' => 'orion-tech-suites',
            'thumbnail_image' => '/storage/uploads/projects/orion-1.jpg',
            'gallery_images' => [
                ['url' => '/storage/uploads/projects/orion-1.jpg', 'caption' => 'Photo 1'],
                ['url' => '/storage/uploads/projects/orion-2.jpg', 'caption' => 'Photo 2'],
                ['url' => '/storage/uploads/projects/orion-3.jpg', 'caption' => 'Photo 3'],
            ],
        ]);

        $editResponse = $this->actingAs($this->admin)
            ->get(route('admin.projects.edit', $project));

        $editResponse->assertStatus(200);
        $editResponse->assertSee('Project Photography Gallery', false);

        // Update: Keep photo 3 and photo 1 in reverse order, remove photo 2, and add a new photo via URL
        $updateResponse = $this->actingAs($this->admin)
            ->put(route('admin.projects.update', $project), [
                'title' => 'Orion Tech Suites Updated',
                'slug' => 'orion-tech-suites',
                'thumbnail_image' => '/storage/uploads/projects/orion-3.jpg',
                'gallery_items' => [
                    ['url' => '/storage/uploads/projects/orion-3.jpg', 'caption' => 'Updated Photo 3'],
                    ['url' => '/storage/uploads/projects/orion-1.jpg', 'caption' => 'Updated Photo 1'],
                    ['url' => '/storage/uploads/projects/orion-4.jpg', 'caption' => 'New Photo 4'],
                ],
            ]);

        $updateResponse->assertRedirect(route('admin.projects.index'));

        $project->refresh();
        $this->assertEquals('Orion Tech Suites Updated', $project->title);
        $this->assertCount(3, $project->gallery_images);
        $this->assertEquals('/storage/uploads/projects/orion-3.jpg', $project->gallery_images[0]['url']);
        $this->assertEquals('/storage/uploads/projects/orion-1.jpg', $project->gallery_images[1]['url']);
        $this->assertEquals('/storage/uploads/projects/orion-4.jpg', $project->gallery_images[2]['url']);
        $this->assertEquals('Updated Photo 3', $project->gallery_images[0]['caption']);
    }

    public function test_api_project_show_returns_normalized_gallery_images_and_gallery_urls(): void
    {
        $project = Project::where('slug', 'sanlam-insurance')->first();
        $this->assertNotNull($project);

        $response = $this->getJson('/api/v1/projects/' . $project->slug);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'slug',
                'thumbnail_image',
                'banner_image',
                'gallery_images',
                'gallery_urls',
                'stats',
                'category',
            ],
            'related_projects',
        ]);

        $data = $response->json('data');
        $this->assertIsArray($data['gallery_images']);
        $this->assertGreaterThanOrEqual(2, count($data['gallery_images']));
        $this->assertArrayHasKey('url', $data['gallery_images'][0]);
        $this->assertIsArray($data['gallery_urls']);
    }
}
