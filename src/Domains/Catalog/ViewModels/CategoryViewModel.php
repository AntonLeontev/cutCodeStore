<?php

namespace Src\Domains\Catalog\ViewModels;

use Illuminate\Database\Eloquent\Collection;
use Src\Domains\Catalog\Models\Category;
use Src\Support\Traits\Makeable;

class CategoryViewModel
{
	use Makeable;

	public function homePage(): Collection | array
	{
		return cache()->rememberForever('category_home_page', function() {
			return Category::onHome(1)->get();
		});
	}
}
