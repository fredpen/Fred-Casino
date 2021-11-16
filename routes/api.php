<?php

use App\Http\Controllers\UserController;
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


// auth
Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('logout',  [UserController::class, 'logout']);
    });
});


// user
Route::group(['prefix' => 'user'], function () {

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('details',  [UserController::class, 'userDetails']);
        Route::post('update-user', [UserController::class, 'updateUser']);

    });
});
