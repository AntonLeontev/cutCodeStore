<?php

namespace Src\Support\ValueObjects;

use InvalidArgumentException;
use Src\Support\Traits\Makeable;
use Stringable;

class Price implements Stringable
{
	use Makeable;

	private array $currencies = [
		'RUB' => '₽',
	];

	public function __construct (
		private readonly int $value,
		private readonly string $currency = 'RUB',
		private readonly int $precition = 100
	)
	{
		if($value < 0) {
			throw new InvalidArgumentException('Price must be greater than zero');
		}

		if(!isset($this->currencies[$currency])) {
			throw new InvalidArgumentException('Currency not allowed');
		}
	}

	public function raw(): int
	{
	  return $this->value;
	}

	public function value(): int | float
	{
	  return $this->value / $this->precition;
	}

	public function currency(): string
	{
		return $this->currency;
	}

	public function symbol(): string
	{
		return $this->currencies[$this->currency()];
	}

	public function __toString(): string
	{
		return sprintf('%s %s', number_format($this->value(), 0, ',', ' '), $this->symbol());
	}
}
