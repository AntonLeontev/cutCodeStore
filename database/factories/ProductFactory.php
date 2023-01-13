<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Domains\Catalog\Models\Brand;
use Src\Domains\Catalog\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => $this->faker->fixturesImage('products', 'products'),
            'price' => $this->faker->numberBetween(1000, 100000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'on_home' => $this->faker->numberBetween(0, 1),
			'text' => $this->faker->realText(),
        ];
    }
}
