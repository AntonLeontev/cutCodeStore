<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Domains\Catalog\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
	protected $model = Category::class;
	
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'on_home' => $this->faker->numberBetween(0, 1),
        ];
    }
}
