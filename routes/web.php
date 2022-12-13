<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', HomeController::class)->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'signIn')->name('sign-in');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('store');
    Route::get('/forgot-password', 'forgotPassword')
    ->middleware('guest')
    ->name('forgot-password');
    Route::post('/forgot-password', 'remindPassword')->middleware('guest')->name('remind-password');
    Route::get('/reset-password/{token}', 'resetPassword')
    ->middleware('guest')
    ->name('password.reset');
    Route::post('/reset-password', 'update')->middleware('guest')->name('password.update');
    Route::delete('/logout', 'logout')->name('logout');
});

Route::get('/auth/socialite/github/redirect', [GithubController::class, 'redirect'])
    ->name('github.redirect');

Route::get('/auth/socialite/github/callback', [GithubController::class, 'callback']);
