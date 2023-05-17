<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\Dashboard\HomeController;
use App\Http\Controllers\Backend\Admin\MasterOffice\DetailMasterOffice;
use App\Http\Controllers\Backend\Admin\MasterOffice\ManagementOfficeController;
use App\Http\Controllers\Backend\Admin\Profile\UserProfileController;


// List of Routes

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'master-office'], function () {

        Route::resource('management-office', ManagementOfficeController::class);
        Route::group(['prefix' => 'detail'], function () {
            Route::get('/', [DetailMasterOffice::class, 'index'])->name('detail-master-office.index');
            Route::get('/show-employee/{office}', [DetailMasterOffice::class, 'showEmployee'])->name('detail-master-office.show-employee');
        });

    });
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});

// Authentication Route
require __DIR__ . '/auth.php';
