<?php

namespace Src\Domains\Auth\Actions;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Src\Domains\Auth\Contracts\RegisterNewUserContract;
use Src\Domains\Auth\Models\User;

class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(string $name, string $email, string $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        auth()->login($user, true);

        event(new Registered($user));
    }
}
