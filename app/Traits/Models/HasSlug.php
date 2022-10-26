<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
	protected static function bootHasSlug(): void
	{
		static::creating(function (Model $item) {
			$item->slug = $item->slug ?? self::createSlug($item);
		});
	}

	protected static function slugFrom(): string
	{
		return 'title';
	}

	protected static function createSlug(Model $item): string
	{
		$slug = str($item->{self::slugFrom()})->slug();
		$numberOfSameSlugs = $item->where('slug', 'like', "$slug%")->count();

		if ($numberOfSameSlugs === 0) {
			return $slug;
		}

		return sprintf('%s-%s', $slug, $numberOfSameSlugs + 1);
	}
}
