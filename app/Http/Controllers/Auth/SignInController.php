<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function page()
    {
        return view('auth.login');
    }

    public function handle(SignInRequest $request)
    {
        if (!Auth::attempt($request->validated(), true)) {
            return back()
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout()
    {
        auth()->logout();

        request()
            ->session()
            ->invalidate();

        request()
            ->session()
            ->regenerateToken();

        return redirect()->intended(route('home'));
    }
}
