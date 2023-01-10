<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignUpRequest;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Src\Domains\Auth\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_page()
    {
        $response = $this->get(action([SignInController::class, 'page']));

        $response
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_register_page()
    {
        $response = $this->get(action([SignUpController::class, 'page']));

        $response
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_forgot_password_page()
    {
        $response = $this->get(action([ForgotPasswordController::class, 'page']));

        $response
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_reset_password_page()
    {
        $response = $this->get(
            action(
                [ResetPasswordController::class, 'page'],
                ['token' => '123']
            )
        );

        $response
            ->assertOk()
            ->assertViewIs('auth.reset-password');
    }

    public function test_logout()
    {
        $user = UserFactory::new()->create([
            'email' => 'test@ya.ru',
        ]);
        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logout']));

        $this->assertGuest();
    }

    public function test_sign_in_success()
    {
        $request = [
            'email' => 'test@ya.ru',
            'password' => bcrypt('12345678'),
        ];

        $user = UserFactory::new()->create($request);

        $request['password'] = '12345678';

        $request = $this->post(
            action([SignInController::class, 'handle']),
            $request
        );

        $request
            ->assertValid()
            ->assertRedirectToRoute('home');

        $this->assertAuthenticatedAs($user);
    }

    public function test_sign_up_handler()
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
            action([SignUpController::class, 'handle']),
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
        $user = UserFactory::new()->create($request);

        $response = $this->post(action([ForgotPasswordController::class, 'handle'], $request));

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
            ->post(action([ForgotPasswordController::class, 'handle'], $request));

        $response
            ->assertSessionHasErrors(['email'])
            ->assertRedirectToRoute('forgot-password');
    }

    public function test_update_password_success()
    {
        Event::fake();

        $originalPassword = str()->random(10);
        $newPassword = str()->random(10);

        $user = UserFactory::new()->create([
            'password' => Hash::make($originalPassword),
        ]);

        $request = [
            'token' => Password::broker()->createToken($user),
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $response = $this->post(
            action([ResetPasswordController::class, 'handle'], $request)
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
