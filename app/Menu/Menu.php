<?php

namespace App\Menu;

use Illuminate\Support\Collection;
use IteratorAggregate;
use Src\Support\Traits\Makeable;
use Traversable;

class Menu implements IteratorAggregate
{
	use Makeable;

	private array $items = [];

	public function add(MenuItem $item)
	{
		$this->items[] = $item;

		return $this;
	}

	public function all(): Collection
	{
		return Collection::make($this->items);
	}

	public function getIterator(): Traversable
	{
		return $this->all();
	}
}
