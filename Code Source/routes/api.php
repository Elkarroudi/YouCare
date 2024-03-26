<?php

use App\Http\Controllers\Auth\Authenticate;
use App\Http\Controllers\Auth\Registration;
use Illuminate\Http\Request;
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

Route::post('/register/organizer', [Registration::class, 'organizer']);
Route::post('/register/volunteer', [Registration::class, 'volunteer']);
