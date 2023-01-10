<?php

namespace Tests\Feature\Support\Casts;

use Database\Factories\ProductFactory;
use Src\Support\ValueObjects\Price;
use Tests\TestCase;

class PriceCastsTest extends TestCase
{
	private $product;

	public function setUp(): void
	{
		parent::setUp();

		$this->product = ProductFactory::new()->create(['price' => 125000]);
	}

	public function test_geting_price()
	{
		$this->assertInstanceOf(Price::class, $this->product->price);
	}

	public function test_setting_price()
	{
		$this->assertDatabaseHas('products', ['price' => 125000]);
	}
}
