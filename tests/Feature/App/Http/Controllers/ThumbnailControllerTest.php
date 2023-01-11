<?php

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
	
	public function test_ok()
	{
		$size = '500x500';
		$method = 'fit';
		$storage = Storage::disk('image');

		config()->set('thumbnail', ['allowed_sizes' => [$size]]);

		$product = ProductFactory::new()->create();
		
		$response = $this->get($product->makeThumbnail($size, $method));

		$response->assertOk();

		$storage->assertExists(
			"products/$method/$size/" . File::basename($product->thumbnail)
		);
	}


}
