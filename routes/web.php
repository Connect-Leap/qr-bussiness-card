<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\Dashboard\HomeController;
use App\Http\Controllers\Backend\Admin\Profile\UserProfileController;


// List of Routes

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});

// Authentication Route
require __DIR__ . '/auth.php';
