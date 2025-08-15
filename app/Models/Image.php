<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path',
    ];

    protected $appends = ['url'];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'image_id');
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class, 'image_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'image_id');
    }

    public function getUrlAttribute(): string
    {
        if (filter_var($this->path, FILTER_VALIDATE_URL)) {
            return $this->path;
        }

        // Check if we're using S3 or cloud storage (including Laravel Cloud)
        if (config('filesystems.default') === 's3') {
            return Storage::disk('s3')->url($this->path);
        }

        // For local storage
        return asset('storage/' . $this->path);
    }
}
