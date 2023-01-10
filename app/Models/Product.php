<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
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
    use Searchable;

    protected $fillable = ['slug', 'title', 'thumbnail', 'price', 'brand_id', 'on_home', 'text'];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    #[SearchUsingFullText(['title', 'text'])]
    public function toSearchableArray()
    {
        return [
            'title' => $this->id,
            'text' => $this->text,
        ];
    }

    public function scopeFiltered(Builder $query)
    {
        $query
            ->when(request('filters.brands'), function (Builder $query) {
                $query->whereIn('brand_id', request('filters.brands'));
            })
            ->when(request('filters.price'), function (Builder $query) {
                $query->whereBetween('price', [
					request('filters.price.from', 0) * 100, 
					request('filters.price.to', 100000) * 100
				]);
            });
    }

    public function scopeSorted(Builder $query)
    {
        $query->when(request('sort'), function (Builder $query) {
            $column = request()->str('sort');

            $direction = $column->contains('-') ? 'DESC' : 'ASC';

            $query->orderBy((string) $column->remove('-'), $direction);
        });
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
