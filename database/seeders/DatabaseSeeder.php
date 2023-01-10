<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\CategoryProductFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use Src\Domains\Catalog\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        BrandFactory::new()->count(10)->create();
        CategoryFactory::new()->count(7)
			->has(Product::factory(rand(5, 15)))
			->create();
		
		foreach(Product::all() as $product) {
			$categories = Category::inRandomOrder()->take(rand(1, 2))->pluck('id');
			$product->categories()->attach($categories);
		}
    }
}
