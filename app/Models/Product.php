<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\Domains\Catalog\Models\Brand;
use Src\Domains\Catalog\Models\Category;
use Src\Support\Casts\PriceCast;
use Src\Support\Traits\Models\HasSlug;
use Src\Support\Traits\Models\HasThumbnail;

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

	protected $casts = [
		'price' => PriceCast::class
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
