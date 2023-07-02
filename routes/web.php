<?php

use App\Http\Controllers\Backend\Admin\Configuration\ApplicationSettingController;
use App\Http\Controllers\Backend\Admin\Configuration\InformationSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\Dashboard\HomeController;
use App\Http\Controllers\Backend\Admin\Dashboard\ShowScannerController;
use App\Http\Controllers\Backend\Admin\MasterOffice\DetailMasterOffice;
use App\Http\Controllers\Backend\Admin\MasterOffice\ManagementOfficeController;
use App\Http\Controllers\Backend\Admin\MasterUser\Employee\MasterEmployeeController;
use App\Http\Controllers\Backend\Admin\MasterUser\Supervisor\MasterSupervisorController;
use App\Http\Controllers\Backend\Admin\MasterUser\UserManagementController;
use App\Http\Controllers\Backend\Admin\MasterUser\UsersController;
use App\Http\Controllers\Backend\Admin\Profile\UserProfileController;
use App\Http\Controllers\Backend\Admin\QR\CardSimulatorController;
use App\Http\Controllers\Backend\Admin\QR\GeneralQrController;
use App\Http\Controllers\Backend\Admin\QR\QrController;

// List of Routes

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/show-scanner-agent', [ShowScannerController::class, 'show'])->name('show-scanner-agent');

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

    Route::group(['prefix' => 'master-qr'], function () {
        Route::get('/', [QrController::class, 'index'])->name('master-qr.index');
        Route::get('/create', [QrController::class, 'create'])->name('master-qr.create');
        Route::post('/create', [QrController::class, 'store'])->name('master-qr.store');
        Route::get('/create-vcard', [QrController::class, 'createVcard'])->name('master-qr.create-vcard');
        Route::post('/create-vcard', [QrController::class, 'storeVcard'])->name('master-qr.store-vcard');
        Route::get('/{id}/reset-limit', [QrController::class, 'resetUserQrCode'])->name('master-qr.reset-user-qr-code');
        Route::get('/reset-user-limit', [QrController::class, 'resetAllUserQrCode'])->name('master-qr.reset-all-user-qr-code');
        Route::get('/{id}/edit', [QrController::class, 'edit'])->name('master-qr.edit');
        Route::put('/{id}', [QrController::class, 'update'])->name('master-qr.update');
        Route::delete('/{id}/destroy', [QrController::class, 'destroy'])->name('master-qr.destroy');
        Route::get('/{id}/show-detail-qr', [QrController::class, 'showDetailQr'])->name('master-qr.show-detail-qr');
        Route::get('/{id}/activate', [QrController::class, 'activateSpecifiedUserQr'])->name('master-qr.activate');
        Route::get('/{id}/block', [QrController::class, 'blockSpecifiedUserQr'])->name('master-qr.block');

        Route::group(['prefix' => 'card-simulator'], function () {
            Route::get('/', [CardSimulatorController::class, 'findUserView'])->name('card-simulator.index');
            Route::get('/view-card', [CardSimulatorController::class, 'showCard'])->name('card-simulator.show');
        });

        Route::group(['prefix' => 'general-qr'], function () {
            Route::get('/', [GeneralQrController::class, 'index'])->name('general-qr.index');
            Route::get('/create', [GeneralQrController::class, 'create'])->name('general-qr.create');
            Route::get('/create-vcard', [GeneralQrController::class, 'createVcard'])->name('general-qr.create-vcard');
            Route::post('/create', [GeneralQrController::class, 'store'])->name('general-qr.store');
            Route::post('/create-vcard', [GeneralQrController::class, 'storeVcard'])->name('general-qr.store-vcard');
            Route::delete('/{id}/destroy', [GeneralQrController::class, 'destroy'])->name('general-qr.destroy');
            Route::get('/{id}/reset-limit', [GeneralQrController::class, 'resetGeneralQrCode'])->name('general-qr.reset-general-qr-code');
            Route::get('/reset-general-qr-limit', [GeneralQrController::class, 'resetAllGeneralQrCode'])->name('general-qr.reset-all-general-qr-code');
            Route::get('/{id}/show-detail-qr', [GeneralQrController::class, 'showDetailQr'])->name('general-qr.show-detail-qr');
            Route::get('/{id}/activate', [GeneralQrController::class, 'activateSpecifiedGeneralQr'])->name('general-qr.activate');
            Route::get('/{id}/block', [GeneralQrController::class, 'blockSpecifiedGeneralQr'])->name('general-qr.block');
        });
    });

    Route::group(['prefix' => 'configuration'], function () {
        Route::group(['prefix' => 'application-setting'], function () {
            Route::get('/', [ApplicationSettingController::class, 'index'])->name('application-setting.index');
            Route::get('/create', [ApplicationSettingController::class, 'create'])->name('application_setting.create');
            Route::post('/create', [ApplicationSettingController::class, 'store'])->name('application-setting.store');
            Route::get('/{id}/edit', [ApplicationSettingController::class, 'edit'])->name('application-setting.edit');
            Route::put('/{id}', [ApplicationSettingController::class, 'update'])->name('application-setting.update');
        });

        Route::group(['prefix' => 'information-setting'], function () {
            Route::get('/', [InformationSettingController::class, 'showInformationSetting'])->name('information-setting.index');
            Route::get('/checkout-transaction-page', [InformationSettingController::class, 'showCheckoutTransactionPage'])->name('information-setting.order-page');
            Route::put('/update', [InformationSettingController::class, 'updateInformationSetting'])->name('information-setting.update');
            Route::post('/checkout-order', [InformationSettingController::class, 'checkoutOrder'])->name('information-setting.checkout-order');
        });
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [UserProfileController::class, 'show'])->name('profile.show');
        Route::put('/update', [UserProfileController::class, 'update'])->name('profile.update');
        Route::get('/show-card', [UserProfileController::class, 'showCard'])->name('profile.show-card');
        Route::put('/update-user-profile', [UserProfileController::class, 'updateProfilePicture'])->name('profile.update-user-profile');
    });

    // Law Policy
    Route::get('/privacy-policy', function () {
        return view('pages.law-policy.privacy-policy');
    })->name('privacy-policy');

    Route::get('/terms-and-agreement', function () {
        return view('pages.law-policy.terms-and-agreement');
    })->name('terms-and-agreement');
});

// Authentication Route
require __DIR__ . '/auth.php';

// Short Url Route
require __DIR__ . '/short-url.php';

