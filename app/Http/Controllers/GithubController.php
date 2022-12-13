<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::firstOrCreate(
            [
                'email' => $githubUser->email
            ],
            [
                'github_id' => $githubUser->id,
                'name'      => $githubUser->name,
                'password'  => Hash::make(str()->random(20)),
            ]
        );

        auth()->login($user);

        return redirect()->route('home');
    }
}
