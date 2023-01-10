<?php

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
	public function test_creating_new_directory()
	{
		Storage::fake('image');

		Storage::disk('image')->assertMissing('/storage/images/products/resize/345x320');
		//TODO
		// $this->get('/storage/images/products/resize/345x320/test-image.jpg');

		// Storage::disk('image')->assertExists('/storage/images/products/resize/345x320');
	}
}
