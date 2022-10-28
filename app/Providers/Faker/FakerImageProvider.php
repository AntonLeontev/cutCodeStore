<?php

namespace App\Providers\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
	public function fixturesImage(string $fixturesDir, string $storageDir): string
	{
		$this->createDirectory($storageDir);
		return $this->saveImage($fixturesDir, $storageDir);
	}

	private function createDirectory(string $storageDir): void
	{
		if (!Storage::exists($storageDir)) {
			Storage::makeDirectory($storageDir);
		}
	}

	private function saveImage(string $fixturesDir, string $storageDir): string
	{
		$file = $this->generator->file(
			base_path('/tests/Fixtures/images/' . $fixturesDir),
			Storage::path($storageDir),
			false
		);

		return '/storage/' . trim($storageDir, '/') . '/' . $file;
	}
}
