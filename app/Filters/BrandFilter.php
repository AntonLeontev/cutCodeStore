<?php

namespace App\Filters;

use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Src\Domains\Catalog\Filters\AbstractFilter;
use Src\Domains\Catalog\Models\Brand;

class BrandFilter extends AbstractFilter
{
	public function title(): string
	{
		return 'Бренд';
	}
	
	public function key(): string
	{
		return 'brand';
	}
	
	public function apply(Builder $query): Builder
	{
		return $query->when($this->requestValue(), function (Builder $query) {
                $query->whereIn('brand_id', $this->requestValue());
            });
	}

	public function values(): array
	{
		$category = request()->route('category');

		if (!is_null($category)) {
			$productsIds = $category->products->pluck('id')->toArray();
			
			$brandsIds = $category->products->pluck('brand_id')->toArray();
		}

		if (is_null($category)) {
			$productsIds = Product::all('id')->toArray();
		}

		return Brand::select(['id', 'title'])
			->when(
				!is_null($category), 
				fn(Builder $query) => $query->whereIn('id', $brandsIds)
			)
			->withCount(['products' => function(Builder $query) use ($category, $productsIds) {
				$query->when(
					!is_null($category), 
					fn(Builder $query) => $query->whereIn('id', $productsIds)
				);
			}])			
			->get()
			->toArray();

	}

	public function view(): string
	{
		return 'catalog.filters.brand';
	}
}
