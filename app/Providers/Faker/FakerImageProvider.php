<?php

namespace App\Providers\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
	public function fixturesImage(string $fixturesDir, string $storageDir): string
	{
		$storage = Storage::disk('image');

		if (!$storage->exists($storageDir)) {
			$storage->makeDirectory($storageDir);
		}
		
		return $this->generator->file(
			base_path('/tests/Fixtures/images/' . $fixturesDir),
			$storage->path($storageDir),
			false
		);
	}
}
