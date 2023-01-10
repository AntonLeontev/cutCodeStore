<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function (){
            Route::controller(SignInController::class)->group(function(){
                Route::get('/login', 'page')
                    ->name('login');
                Route::post('/login', 'handle')
                    ->middleware('throttle::auth')
                    ->name('sign-in');
                Route::delete('/logout', 'logout')
                    ->name('logout');
            });

            Route::controller(SignUpController::class)->group(function(){
                Route::get('/register', 'page')
                    ->name('register');
                Route::post('/register', 'handle')
                    ->middleware('throttle::auth')
                    ->name('store');
            });

            Route::controller(ForgotPasswordController::class)->group(function (){
                Route::get('/forgot-password', 'page')
                    ->middleware('guest')
                    ->name('forgot-password');
                Route::post('/forgot-password', 'handle')
                    ->middleware('guest')
                    ->name('remind-password');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('/reset-password/{token}', 'page')
                    ->middleware('guest')
                    ->name('password.reset');
                Route::post('/reset-password', 'handle')
                    ->middleware('guest')
                    ->name('password.update');

            });

            Route::get('/auth/socialite/{driver}/redirect', [SocialAuthController::class, 'redirect'])
                ->name('social.redirect');

            Route::get('/auth/socialite/{driver}/callback', [SocialAuthController::class, 'callback'])
                ->name('social.callback');
        });
    }
}
