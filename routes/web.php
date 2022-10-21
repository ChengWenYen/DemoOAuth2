<?php

use App\Http\Controllers\Admins\AuthController;
use App\Http\Controllers\Admins\NotificationController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admins\UserController as ManageUserController;
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

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('login', [AuthController::class, 'show'])->name('auth.show');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth')->group(function() {
        Route::prefix('notifications')->name('notify.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/', [NotificationController::class, 'store'])->name('store');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [ManageUserController::class, 'index'])->name('index');
        });
    });
});

Route::get('/', [OAuthController::class, 'show'])->name('login');

Route::prefix('oauth/member/v2/')->group(function() {
    Route::get('line/login/callback', [OAuthController::class, 'lineLoginCallback']);
    Route::get('google/login/callback', [OAuthController::class, 'googleLoginCallback']);

    Route::get('line/notify/login/callback', [OAuthController::class, 'lineNotifyLoginCallback'])->middleware('auth');
});

Route::middleware('auth')->group(function() {
    Route::post('logout', [OAuthController::class, 'logout'])->name('logout');
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::put('users/{user_id}', [UserController::class, 'update'])->name('users.update');
});
