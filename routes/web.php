<?php

use App\Http\Controllers\Backend\Admin\Configuration\ApplicationSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\Dashboard\HomeController;
use App\Http\Controllers\Backend\Admin\MasterOffice\DetailMasterOffice;
use App\Http\Controllers\Backend\Admin\MasterOffice\ManagementOfficeController;
use App\Http\Controllers\Backend\Admin\MasterUser\Employee\MasterEmployeeController;
use App\Http\Controllers\Backend\Admin\MasterUser\Supervisor\MasterSupervisorController;
use App\Http\Controllers\Backend\Admin\MasterUser\UserManagementController;
use App\Http\Controllers\Backend\Admin\MasterUser\UsersController;
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

    Route::group(['prefix' => 'master-user'], function () {
        Route::get('/', [UsersController::class, 'seeAllUsers'])->name('master-user.all');
        Route::resource('management-employee', MasterEmployeeController::class);
        Route::resource('management-supervisor', MasterSupervisorController::class);
    });

    Route::group(['prefix' => 'configuration'], function () {
        Route::group(['prefix' => 'application-setting'], function () {
            Route::get('/', [ApplicationSettingController::class, 'index'])->name('application-setting.index');
            Route::get('/create', [ApplicationSettingController::class, 'create'])->name('application_setting.create');
            Route::get('/{id}/edit', [ApplicationSettingController::class, 'edit'])->name('application-setting.edit');
        });
    });

	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});

// Authentication Route
require __DIR__ . '/auth.php';
