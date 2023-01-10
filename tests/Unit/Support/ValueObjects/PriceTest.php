<?php

namespace Tests\Unit\Support\ValueObjects;

use InvalidArgumentException;
use Src\Support\ValueObjects\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{
    public function test_raw()
    {
        $price = Price::make(10000);

        $this->assertSame(10000, $price->raw());
    }

	public function test_currency()
	{
		$price = Price::make(10000);

        $this->assertSame('RUB', $price->currency());
	}

	public function test_symbol()
	{
		$price = Price::make(10000);

        $this->assertSame('₽', $price->symbol());
	}

	/**
     * @test
     * @dataProvider valueTests
     */
	public function test_value($input, $expected)
	{
		$price = Price::make($input);

        $this->assertSame($expected, $price->value());
	}

	public function valueTests(): array
	{
		return [
			[10000, 100],
			[10, 0.1],
			[10056, 100.56],
		];
	}

	/**
     * @dataProvider toStringTests
     */
	public function test_to_string($input, $expected)
	{
		$price = Price::make($input);

		$this->assertSame($expected, $price->__toString());
	}

	public function toStringTests(): array
	{
		return [
			[10000, '100 ₽'],
			[0, '0 ₽'],
			[10, '0 ₽'],
			[50, '1 ₽'],
			[100050, '1 001 ₽'],
			[100049, '1 000 ₽'],
			[100000050, '1 000 001 ₽'],
			[100000049, '1 000 000 ₽'],
		];
	}

	public function test_negative_value()
	{
		$this->expectException(InvalidArgumentException::class);

		Price::make(-1);
	}

	public function test_not_allowed_currency()
	{
		$this->expectException(InvalidArgumentException::class);
		
		Price::make(100, 'USD');
	}
}
