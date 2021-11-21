<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/users', [HomeController::class, 'users'])->name('users');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/casinos', [HomeController::class, 'casinos'])->name('casinos');
    Route::get('/listings', [HomeController::class, 'listings'])->name('listings');
});


require __DIR__.'/auth.php';
