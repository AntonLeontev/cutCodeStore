<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method()
    {
        $response = $this->get(action([AuthController::class, 'login']));

        $response
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_register_method()
    {
        $response = $this->get(action([AuthController::class, 'register']));

        $response
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_forgot_password_method()
    {
        $response = $this->get(action([AuthController::class, 'forgotPassword']));

        $response
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_reset_password_method()
    {
        $response = $this->get(
            action(
                [AuthController::class, 'resetPassword'],
                ['token' => '123']
            )
        );

        $response
            ->assertOk()
            ->assertViewIs('auth.reset-password');
    }

    public function test_logout()
    {
        $user = User::factory()->create([
            'email' => 'test@ya.ru',
        ]);

        $this->actingAs($user)
            ->delete(action([AuthController::class, 'logout']));

        $this->assertGuest();
    }

    public function test_sign_in_success()
    {
        $request = [
            'email' => 'test@ya.ru',
            'password' => bcrypt('12345678'),
        ];

        $user = User::factory()->create($request);

        $request['password'] = '12345678';

        $request = $this->post(
            action([AuthController::class, 'signIn']),
            $request
        );

        $request
            ->assertValid()
            ->assertRedirectToRoute('home');

        $this->assertAuthenticatedAs($user);
    }

    public function test_method_store()
    {
        Event::fake();
        Notification::fake();

        $request = SignUpRequest::factory()->create([
            'email' => 'test@ya.ru',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(
            action([AuthController::class, 'store']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        Event::assertDispatched(Registered::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirectToRoute('home');
    }

    public function test_reminding_password()
    {
        Notification::fake();

        $request = ['email' => 'test@ya.ru'];
        $user = User::factory()->create($request);

        $response = $this->post(action([AuthController::class, 'remindPassword'], $request));

        Notification::assertSentTo($user, ResetPassword::class);

        $response
            ->assertSessionHasAll(['shop_flash_message', 'shop_flash_class'])
            ->assertValid()
            ->assertRedirectToRoute('home');
    }

    public function test_reminding_password_error()
    {
        $request = ['email' => 'test@ya.ru'];

        $response = $this->from(route('forgot-password'))
            ->post(action([AuthController::class, 'remindPassword'], $request));

        $response
            ->assertSessionHasErrors(['email'])
            ->assertRedirectToRoute('forgot-password');
    }

    public function test_update_password_success()
    {
        Event::fake();

        $originalPassword = str()->random(10);
        $newPassword = str()->random(10);

        $user = User::factory()->create([
            'password' => Hash::make($originalPassword),
        ]);

        $request = [
            'token' => Password::broker()->createToken($user),
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $response = $this->post(
            action([AuthController::class, 'update'], $request)
        );

        $user->refresh();

        Event::assertDispatched(PasswordReset::class);

        $this->assertTrue(Hash::check($newPassword, $user->password));
        $this->assertFalse(Hash::check($originalPassword, $user->password));

        $response
            ->assertSessionHasAll(['shop_flash_message', 'shop_flash_class'])
            ->assertValid()
            ->assertRedirectToRoute('login');
    }
}
