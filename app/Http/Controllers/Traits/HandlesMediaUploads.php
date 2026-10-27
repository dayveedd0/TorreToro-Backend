<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesMediaUploads
{
    /**
     * Handle single file upload or fallback to direct URL.
     */
    protected function handleMediaField(
        Request $request,
        string $fileInputName,
        string $urlInputName,
        ?string $currentValue = null,
        string $directory = 'uploads'
    ): ?string {
        if ($request->hasFile($fileInputName) && $request->file($fileInputName)->isValid()) {
            $file = $request->file($fileInputName);
            $extension = $file->getClientOriginalExtension();
            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = Str::slug($baseName) . '-' . time() . '.' . $extension;

            $path = $file->storeAs($directory, $safeName, 'public');

            return '/storage/' . $path;
        }

        // If user submitted an explicit URL input
        if ($request->has($urlInputName)) {
            $url = trim($request->input($urlInputName, ''));
            return $url !== '' ? $url : $currentValue;
        }

        return $currentValue;
    }

    /**
     * Handle multiple file uploads and return array of public URLs.
     */
    protected function handleMultipleMediaFiles(
        Request $request,
        string $fileInputName,
        string $directory = 'uploads/projects'
    ): array {
        $urls = [];

        if ($request->hasFile($fileInputName)) {
            $files = $request->file($fileInputName);
            if (! is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeName = Str::slug($baseName) . '-' . uniqid() . '.' . $extension;

                    $path = $file->storeAs($directory, $safeName, 'public');
                    $urls[] = '/storage/' . $path;
                }
            }
        }

        return $urls;
    }

    /**
     * Delete an asset from public storage if it was locally uploaded.
     */
    protected function deleteLocalMedia(?string $url): void
    {
        if ($url && Str::startsWith($url, '/storage/')) {
            $relativePath = Str::after($url, '/storage/');
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }
}
