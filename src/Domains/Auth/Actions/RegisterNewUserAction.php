<?php

namespace Src\Domains\Auth\Actions;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Src\Domains\Auth\Contracts\RegisterNewUserContract;
use Src\Domains\Auth\DTOs\NewUserDTO;
use Src\Domains\Auth\Models\User;

class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUserDTO $data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        auth()->login($user, true);

        event(new Registered($user));
    }
}
