<?php

use App\Http\Controllers\Api\PositionsController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UsersApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1/'], function () {
    Route::get('token', [TokenController::class, 'token'])->name('token');
    Route::get('users', [UsersApiController::class, 'index'])->name('user.api.index');
    Route::post('users', [UsersApiController::class, 'store'])->name('user.api.store');
    Route::get('users/{id}', [UsersApiController::class, 'show'])->name('user.api.show');
    Route::get('positions', [PositionsController::class, 'index'])->name('positions.api.index');
});
