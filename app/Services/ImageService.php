<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Handle image upload and create Image record
     */
    public function handleUpload($path): ?Image
    {
        if (!$path) {
            return null;
        }

        if (is_string($path)) {
            return Image::query()->firstOrCreate(
                ['path' => sanitize_image_name($path)]
            );
        }

        return null;
    }
}
