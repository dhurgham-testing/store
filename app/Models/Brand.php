<?php

namespace App\Models;

use App\BrandStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_id',
        'status',
    ];

    protected $appends = ['image_url'];

    protected $casts = [
        'status' => BrandStatus::class,
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return $this->image->path;
        }
        
        return null;
    }
}
