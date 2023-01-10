<?php

namespace Tests\Feature\Auth\Actions;

use Illuminate\Auth\Events\Registered;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Src\Domains\Auth\DTOs\NewUserDTO;
use Src\Domains\Auth\Contracts\RegisterNewUserContract;

class RegisterNewUserActionTest extends TestCase
{
	public function test_creating_new_user_in_database ()
	{
		Event::fake();

		$this->assertDatabaseMissing('users', ['email' => 'testing@ya.ru']);

		$action = app(RegisterNewUserContract::class);
		$action(NewUserDTO::make('test', 'testing@ya.ru', '12345678'));

		$this->assertDatabaseHas('users', ['email' => 'testing@ya.ru']);
	}

	public function test_creating_event()
	{
		Event::fake();

		$action = app(RegisterNewUserContract::class);
		$action(NewUserDTO::make('test', 'testing@ya.ru', '12345678'));

		Event::assertDispatched(Registered::class);
	}
}
