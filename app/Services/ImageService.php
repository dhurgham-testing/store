<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Handle image upload and create Image record
     */
    public function handleUpload($imageData, string $altText = null): ?Image
    {
        if (!$imageData) {
            return null;
        }

        if (is_string($imageData)) {
            return Image::query()->firstOrCreate(
                ['path' => $imageData],
                ['alt_text' => $altText]
            );
        }

        if (is_array($imageData) && !empty($imageData)) {
            $path = $imageData[0] ?? null;

            if ($path) {
                return Image::query()->firstOrCreate(
                    ['path' => $path],
                    ['alt_text' => $altText]
                );
            }
        }

        return null;
    }

    /**
     * Delete image file and record
     */
    public function deleteImage(Image $image): bool
    {
        try {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get image URL for display
     */
    public function getImageUrl(?Image $image): string
    {
        if (!$image || !$image->path) {
            return 'https://via.placeholder.com/400x300?text=No+Image';
        }

        return Storage::disk('public')->url($image->path);
    }
}
