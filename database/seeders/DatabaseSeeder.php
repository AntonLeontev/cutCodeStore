<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
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
        BrandFactory::new()->count(20)->create();
        CategoryFactory::new()->count(10)->create();
		ProductFactory::new()->count(5000)->create();
		
		foreach(Category::all() as $category) {
			$products = Product::inRandomOrder()->take(rand(500, 600))->pluck('id');
			$category->products()->attach($products);
		}
    }
}
