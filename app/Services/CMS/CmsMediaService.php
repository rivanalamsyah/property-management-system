<?php

namespace App\Services\CMS;

use App\Models\CmsMedia;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class CmsMediaService
{
    /**
     * Upload an asset to the Media Library.
     */
    public function upload(UploadedFile $file, string $folder = '/', ?string $altText = null): CmsMedia
    {
        // Sanitize folder path to prevent path traversal
        $folder = preg_replace('/[^a-zA-Z0-9\/_-]/', '', $folder);
        $folder = preg_replace('/\.\.+/', '', $folder);
        $folder = '/' . trim($folder, '/');

        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        
        // Save to public storage disk
        $path = $file->storeAs('cms-media/' . trim($folder, '/'), $filename, 'public');
        $fileUrl = Storage::disk('public')->url($path);

        // Generate mock responsive variants for testing
        $variants = [
            'thumbnail' => $fileUrl,
            'medium' => $fileUrl,
            'large' => $fileUrl,
        ];

        return CmsMedia::create([
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path,
            'file_url' => $fileUrl,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'folder' => '/' . trim($folder, '/'),
            'alt_text' => $altText ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'responsive_variants' => $variants,
        ]);
    }

    /**
     * Replace an existing media record's physical file on disk.
     */
    public function replace(CmsMedia $media, UploadedFile $newFile): bool
    {
        // Delete old file
        if (Storage::disk('public')->exists($media->filepath)) {
            Storage::disk('public')->delete($media->filepath);
        }

        // Store new file to the exact same path/filename
        $newFile->storeAs(dirname($media->filepath), basename($media->filepath), 'public');

        // Update database record sizes
        $media->update([
            'file_size' => $newFile->getSize(),
            'mime_type' => $newFile->getMimeType(),
        ]);

        return true;
    }

    /**
     * Delete a media asset from both DB and disk.
     */
    public function delete(CmsMedia $media): void
    {
        if (Storage::disk('public')->exists($media->filepath)) {
            Storage::disk('public')->delete($media->filepath);
        }
        $media->delete();
    }
}
