<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use DomainException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Src\Domains\Auth\Models\User;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirect(string $driver)
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Throwable $e) {
            throw new DomainException('Произошла ошибка или драйвер не поддерживается');
        }
    }

    public function callback(string $driver)
    {
        if ($driver !== 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }
        $githubUser = Socialite::driver($driver)->user();

        $user = User::firstOrCreate(
            [
                'email' => $githubUser->email
            ],
            [
                $driver.'_id' => $githubUser->id,
                'name'        => $githubUser->name,
                'password'    => Hash::make(str()->random(20)),
            ]
        );

        auth()->login($user);

        return redirect()->route('home');
    }
}
