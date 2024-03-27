<?php

use App\Http\Controllers\Advertisements;
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

Route::post('/v1/auth/register/organizer/', [Registration::class, 'organizer']);
Route::post('/v1/auth/register/volunteer/', [Registration::class, 'volunteer']);

Route::match(['GET', 'POST'],'/v1/auth/login/', [Authenticate::class, 'login'])->name('login');

Route::post('/v1/auth/logout/', [Authenticate::class, 'logout']);
Route::post('/v1/auth/token/refresh/', [Authenticate::class, 'refresh']);


Route::get('/v1/Advertisements/all/', [Advertisements::class, 'index']);
Route::get('/v1/Advertisements/{advertisement}/', [Advertisements::class, 'show']);
Route::post('/v1/Advertisements/new/', [Advertisements::class, 'create']);
Route::patch('/v1/Advertisements/update/{advertisement}', [Advertisements::class, 'update']);
Route::delete('/v1/Advertisements/delete/soft/{advertisement}', [Advertisements::class, 'delete']);
Route::delete('/v1/Advertisements/delete/force/{id}', [Advertisements::class, 'deletePermanently']);
Route::post('/v1/Advertisements/delete/restore/{id}', [Advertisements::class, 'restore']);
Route::put('/v1/Advertisements/confirm/{advertisement}', [Advertisements::class, 'validateToShow']);

