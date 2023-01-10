<?php

namespace Src\Domains\Catalog\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Domains\Catalog\QueryBuilders\CategoryQueryBuilder;
use Src\Support\Traits\Models\HasSlug;
use Src\Support\Traits\Models\HasThumbnail;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home',
    ];

	public function newEloquentBuilder($query)
	{
		return new CategoryQueryBuilder($query);
	}

    protected function thumbnailDir(): string
    {
        return 'brands';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
