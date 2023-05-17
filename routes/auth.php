<?php

use App\Http\Controllers\Auth\ChangePassword;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPassword;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

    Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');

    Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
    Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');
});


Route::post('logout', [LoginController::class, 'logout'])->name('logout');
