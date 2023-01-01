<?php

use App\Http\Controllers\Api\PositionsController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UsersApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UsersController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/api/v1/'], function () {
    Route::get('token', [TokenController::class, 'token'])->name('token');
    Route::get('users', [UsersApiController::class, 'index']);
    Route::post('users', [UsersApiController::class, 'store'])->name('user.api.store');
    Route::get('users/{id}', [UsersApiController::class, 'show']);
    Route::get('positions', [PositionsController::class, 'index']);
});

Route::resource('users', UsersController::class);
Route::get('/token', [TokenController::class, 'getRegistrationToken'])->name('registration.token');

