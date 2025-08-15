<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Handle image upload and create Image record
     */
    public function handleUpload($imageData): ?Image
    {
        if (!$imageData) {
            return null;
        }

        if (is_string($imageData)) {
            return Image::query()->firstOrCreate(
                ['path' => $imageData]
            );
        }

        if (is_array($imageData) && !empty($imageData)) {
            $path = $imageData[0] ?? null;

            if ($path) {
                return Image::query()->firstOrCreate(
                    ['path' => $path]
                );
            }
        }

        return null;
    }
}
