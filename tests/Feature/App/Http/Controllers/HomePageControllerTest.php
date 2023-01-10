<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Src\Domains\Catalog\Models\Brand;
use Src\Domains\Catalog\Models\Category;
use Tests\TestCase;

class HomePageControllerTest extends TestCase
{
    public function test_home_page()
    {
		CategoryFactory::new()->count(5)->make(['on_home' => 1]);
		ProductFactory::new()->count(5)->make(['on_home' => 1]);
		BrandFactory::new()->count(5)->make(['on_home' => 1]);

        $response = $this->get(action(HomeController::class));

        $response->assertStatus(200)
			->assertViewHas('brands')
			->assertViewHas('products')
			->assertViewHas('categories');
    }
}
