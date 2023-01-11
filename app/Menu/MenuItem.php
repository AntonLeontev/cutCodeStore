<?php

namespace App\Menu;

use Src\Support\Traits\Makeable;

class MenuItem
{
	use Makeable;

	public function __construct(
		protected string $title,
		protected string $link
	)
	{
	}

	public function title()
	{
		return $this->title;
	}

	public function link()
	{
		return $this->link;
	}

	public function isActive(): bool
	{
		$path = parse_url($this->link, PHP_URL_PATH) ?? '/';

		if($path === '/') {
			return $path === request()->path();
		}

		return request()->fullUrlIs($this->link . '*');
	}
}
