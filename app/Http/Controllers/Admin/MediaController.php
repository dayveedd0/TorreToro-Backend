<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $mediaList = $this->getMediaList();
        return view('admin.media.index', compact('mediaList'));
    }

    public function api(Request $request): JsonResponse
    {
        $type = $request->query('type'); // all, image, video
        $search = strtolower($request->query('search', ''));

        $mediaList = $this->getMediaList();

        if ($type === 'image') {
            $mediaList = $mediaList->where('is_image', true);
        } elseif ($type === 'video') {
            $mediaList = $mediaList->where('is_video', true);
        }

        if (!empty($search)) {
            $mediaList = $mediaList->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['name']), $search) || str_contains(strtolower($item['folder']), $search);
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $mediaList->values(),
        ]);
    }

    private function getMediaList()
    {
        $disk = Storage::disk('public');
        $allFiles = $disk->allFiles('uploads');

        return collect($allFiles)->map(function ($filePath) use ($disk) {
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']);
            $isVideo = in_array($extension, ['mp4', 'mov', 'webm', 'ogg']);
            $folder = dirname($filePath);
            $folderName = $folder === 'uploads' ? 'General' : ucfirst(basename($folder));

            return [
                'name' => basename($filePath),
                'path' => $filePath,
                'folder' => $folderName,
                'url' => '/storage/' . $filePath,
                'size' => round($disk->size($filePath) / 1024, 1) . ' KB',
                'size_bytes' => $disk->size($filePath),
                'last_modified' => date('M d, Y H:i', $disk->lastModified($filePath)),
                'is_image' => $isImage,
                'is_video' => $isVideo,
                'extension' => $extension,
            ];
        })->sortByDesc('last_modified')->values();
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|max:102400', // max 100MB
            'folder' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($baseName) . '-' . time() . '.' . $extension;

        $customFolder = $request->input('folder');
        if ($customFolder && in_array($customFolder, ['branding', 'hero', 'about', 'services', 'video', 'maps', 'team', 'projects', 'library'])) {
            $targetFolder = 'uploads/' . $customFolder;
        } else {
            $targetFolder = in_array(strtolower($extension), ['mp4', 'mov', 'webm', 'ogg']) 
                ? 'uploads/videos' 
                : 'uploads';
        }

        $path = $file->storeAs($targetFolder, $safeName, 'public');
        $publicUrl = '/storage/' . $path;

        return back()->with('success', "Asset uploaded successfully! Public URL: {$publicUrl}");
    }

    public function destroy(Request $request): RedirectResponse
    {
        $path = $request->input('path');
        $disk = Storage::disk('public');

        if ($path && Str::startsWith($path, 'uploads/') && $disk->exists($path)) {
            $disk->delete($path);
            return back()->with('success', 'Asset removed from storage.');
        }

        return back()->with('error', 'Asset could not be found or invalid path.');
    }
}
