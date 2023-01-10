<?php

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\SignUpRequest;
use Src\Domains\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
	public NewUserDTO $dto;

	public function test_creating_from_request ()
	{
		$this->dto = NewUserDTO::fromRequest(new SignUpRequest([
			'name' => 'test',
			'email' => 'testing@ya.ru',
			'password' => '123456',
		]));

		$this->assertInstanceOf(NewUserDTO::class, $this->dto);
		$this->assertSame('test', $this->dto->name);
		$this->assertSame('testing@ya.ru', $this->dto->email);
		$this->assertSame('123456', $this->dto->password);
	}
}
