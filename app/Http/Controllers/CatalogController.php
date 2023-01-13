<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Src\Domains\Catalog\Models\Brand;
use Src\Domains\Catalog\Models\Category;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
	{
		$categories = Category::select(['id', 'title', 'slug'])
			->has('products')
			->get();
			
		$products = Product::search(request('search'))
			->query(function(Builder $query) use ($category){
				$query->select(['id', 'title', 'slug', 'price', 'thumbnail'])
					->when($category->exists, function(Builder $query) use ($category){
						$query->whereRelation('categories', 'categories.id', $category->id);
					}
				)
				->filtered()
				->sorted();
			})			
			->paginate(6);

		return view('catalog.index', [
			'activeCategory' => $category, 
			'categories' => $categories, 
			'products' => $products
		]);
	}
}
