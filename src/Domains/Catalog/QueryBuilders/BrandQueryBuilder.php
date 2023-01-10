<?php

namespace Src\Domains\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class BrandQueryBuilder extends Builder
{
	public function onHome()
	{
		return $this->where('on_home', true)->limit(6);
	}
}
