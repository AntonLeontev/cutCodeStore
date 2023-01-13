<?php

use Src\Domains\Catalog\Filters\FilterManager;
use Src\Support\Flash\Flash;

if (!function_exists('flash')) {
	function flash(): Flash
	{
		return app(Flash::class);
	}
}

if (!function_exists('filters')) {
	function filters(): array
	{
		return app(FilterManager::class)->items();
	}
}

