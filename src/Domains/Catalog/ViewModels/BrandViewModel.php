<?php

namespace Src\Domains\Catalog\ViewModels;

use Illuminate\Database\Eloquent\Collection;
use Src\Domains\Catalog\Models\Brand;
use Src\Support\Traits\Makeable;

class BrandViewModel
{
	use Makeable;

	public function homePage(): Collection | array
	{
		return cache()->rememberForever('brand_home_page', function() {
			return Brand::onHome(1)->get();
		});
	}
}
