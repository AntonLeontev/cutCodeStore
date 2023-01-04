<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SignUpRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Src\Domains\Auth\Contracts\RegisterNewUserContract;
use Src\Domains\Auth\Models\User;

class SignUpController extends \App\Http\Controllers\Controller
{
    public function page()
    {
        return view('auth.register');
    }

    public function handle(SignUpRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        //TODO DTOs
        $action(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
        );

        return redirect()->intended(route('home'));
    }
}
