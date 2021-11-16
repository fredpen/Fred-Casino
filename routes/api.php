<?php

use App\Http\Controllers\CasinoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
        Route::get('all',  [UserController::class, 'all']);
        Route::get('{user_id}/show',  [UserController::class, 'show']);
        Route::put('{user_id}/update',  [UserController::class, 'update']);
        Route::delete('{user_id}/delete', [UserController::class, 'delete']);
        Route::get('user-details',  [UserController::class, 'userDetails']);
    });
});

// casinos
Route::group(['prefix' => 'casino'], function () {

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('all',  [CasinoController::class, 'all']);
        Route::post('create',  [CasinoController::class, 'create']);
        Route::get('{casino_id_or_name}/show',  [CasinoController::class, 'show']);
        Route::put('{casino_id}/update',  [CasinoController::class, 'update']);
        Route::delete('{casino_id}/delete', [CasinoController::class, 'delete']);
    });
});
