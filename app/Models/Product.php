<?php

namespace App\Models;

use Src\Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Src\Support\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'price',
        'brand_id',
        'on_home',
    ];

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
