<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ThumbnailController;
use App\Http\Middleware\CatalogViewMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(SignInController::class)->group(function () {
    Route::get('/login', 'page')->name('login');
    Route::post('/login', 'handle')
        ->middleware('throttle:auth')
        ->name('login.handle');
    Route::delete('/logout', 'logout')->name('logout');
});

Route::controller(SignUpController::class)->group(function () {
    Route::get('/sign-up', 'page')->name('register');
    Route::post('/sign-up', 'handle')
        ->middleware('throttle:auth')
        ->name('register.handle');
});

Route::controller(SocialAuthController::class)->group(function () {
    Route::get('/auth/socialite/{driver}', 'redirect')
        ->name('socialite.redirect');

    Route::get('/auth/socialite/{driver}/callback', 'callback')
        ->name('socialite.callback');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'page')
        ->middleware('guest')
        ->name('forgot');

    Route::post('/forgot-password', 'handle')
        ->middleware('guest')
        ->name('forgot.handle');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'page')
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', 'handle')
        ->middleware('guest')
        ->name('password-reset.handle');
});

Route::controller(CatalogController::class)->group(function () {
    Route::get('/catalog/{category:slug?}', CatalogController::class)
        ->middleware([CatalogViewMiddleware::class])
        ->name('catalog');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product/{product:slug}', ProductController::class)
        ->name('product');
});

Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::get('/', 'index')->name('cart');
        Route::post('/{product}/add', 'add')->name('cart.add');
        Route::post('/{item}/quantity', 'quantity')->name('cart.quantity');
        Route::delete('/{item}/delete', 'delete')->name('cart.delete');
        Route::delete('/truncate', 'truncate')->name('cart.truncate');
    });

Route::get('/', HomeController::class)->name('home');

