<?php

use App\Http\Controllers\CasinoController;
use App\Http\Controllers\CasinoListingController;
use App\Http\Controllers\CountryController;
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
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {

    Route::get('all',  [UserController::class, 'all']);
    Route::get('{user_id}/show',  [UserController::class, 'show']);
    Route::put('{user_id}/update',  [UserController::class, 'update']);
    Route::delete('{user_id}/delete', [UserController::class, 'delete']);
    Route::get('user-details',  [UserController::class, 'userDetails']);
});

// casinos
Route::group(['prefix' => 'casino', 'middleware' => 'auth:sanctum'], function () {

    Route::get('all',  [CasinoController::class, 'all']);
    Route::post('create',  [CasinoController::class, 'create']);
    Route::get('{casino_id_or_name}/show',  [CasinoController::class, 'show']);
    Route::post('{casino_id}/update',  [CasinoController::class, 'update']);
    Route::delete('{casino_id}/delete', [CasinoController::class, 'delete']);
});

// casino-listing
Route::group(['prefix' => 'casino-listing', 'middleware' => 'auth:sanctum'], function () {

    Route::get('all',  [CasinoListingController::class, 'all']);
    Route::post('create',  [CasinoListingController::class, 'create']);
    Route::post('{casino_id}/update',  [CasinoListingController::class, 'update']);
    Route::delete('{casino_id}/delete', [CasinoListingController::class, 'delete']);
    Route::get('{casino_id_or_name}/show',  [CasinoListingController::class, 'show']);
    Route::get('casino_id_or_name}/by-casino',  [CasinoListingController::class, 'all']);
    Route::get('country_id_or_name}/by-country',  [CasinoListingController::class, 'all']);
});


// countries
Route::get('countries',  [CountryController::class, 'all'])->middleware('auth:sanctum');
