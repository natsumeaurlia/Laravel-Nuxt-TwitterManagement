<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginAction, RegisterAction, ShowUserAction};
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    Route::post('register', RegisterAction::class)->name('register');
    Route::post('login', LoginAction::class)->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', ShowUserAction::class)->name('show.user');
    Route::apiResource('accounts', AccountController::class);
});
