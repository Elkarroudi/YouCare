<?php

use App\Http\Controllers\Advertisements;
use App\Http\Controllers\Auth\Authenticate;
use App\Http\Controllers\Auth\Registration;
use App\Http\Controllers\User\Helpers;
use App\Http\Controllers\User\Organizer;
use App\Http\Controllers\User\Volunteer;
use App\Http\Controllers\Web\Website;
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

Route::get('/v1/advertisements/all/', [Advertisements::class, 'index']);
Route::get('/v1/advertisements/{advertisement}/', [Advertisements::class, 'show']);
Route::post('/v1/advertisements/new/', [Advertisements::class, 'create']);
Route::patch('/v1/advertisements/update/{advertisement}', [Advertisements::class, 'update']);
Route::delete('/v1/advertisements/delete/soft/{advertisement}', [Advertisements::class, 'delete']);
Route::delete('/v1/advertisements/delete/force/{id}', [Advertisements::class, 'deletePermanently']);
Route::post('/v1/advertisements/delete/restore/{id}', [Advertisements::class, 'restore']);
Route::put('/v1/advertisements/confirm/{advertisement}', [Advertisements::class, 'validateToShow']);

Route::get('/v1/user/global/profile/', [Helpers::class, 'profile']);
Route::post('/v1/user/global/password/update/', [Helpers::class, 'updatePassword']);

Route::post('/v1/user/volunteer/advertisements/apply/{advertisement}/', [Volunteer::class, 'apply']);

Route::get('/v1/website/advertisements/search/', [Website::class, 'advertisements']);
Route::post('/v1/website/advertisements/search/', [Website::class, 'search']);


Route::get('/v1/user/organizer/statistic/', [Organizer::class, 'statistic']);
Route::post('/v1/user/organizer/advertisements/applications/accept/{advertisementOfVolunteer}', [Organizer::class, 'acceptApplication']);
Route::get('/v1/user/organizer/advertisements/applications/all/', [Organizer::class, 'getOrganizerVolunteers']);



