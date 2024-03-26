<?php

use App\Http\Controllers\Auth\Authenticate;
use App\Http\Controllers\Auth\Registration;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('/v1/auth/register/organizer/', [Registration::class, 'organizer']);
    Route::post('/v1/auth/register/volunteer/', [Registration::class, 'volunteer']);
    Route::match(['GET', 'POST'],'/v1/auth/login/', [Authenticate::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('/v1/auth/logout/', [Authenticate::class, 'logout']);
    Route::post('/v1/auth/token/refresh/', [Authenticate::class, 'refresh']);
});

