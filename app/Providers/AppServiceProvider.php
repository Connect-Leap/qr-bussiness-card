<?php

namespace App\Providers;

use App\Services\Auth\DoLogin;
use App\Services\Backend\Configuration\CreateApplicationSetting;
use App\Services\Backend\Configuration\UpdateApplicationSetting;
use App\Services\Backend\MasterOffice\CreateOffice;
use App\Services\Backend\MasterOffice\DeleteOffice;
use App\Services\Backend\MasterOffice\FindOfficeById;
use App\Services\Backend\MasterOffice\ShowRelatedUser;
use App\Services\Backend\MasterOffice\UpdateOffice;
use App\Services\Backend\MasterQR\CreateQR;
use App\Services\Backend\MasterQR\QrProcessing;
use App\Services\Backend\MasterQR\ResetAllUserQr;
use App\Services\Backend\MasterQR\ResetQrLimitByQrId;
use App\Services\Backend\MasterQR\UpdateQR;
use App\Services\Backend\MasterUser\CreateUser;
use App\Services\Backend\MasterUser\DeleteUser;
use App\Services\Backend\MasterUser\UpdateUser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Login
        $this->registerService('DoLogin', DoLogin::class);

        // MasterOffice
        $this->registerService('CreateOffice', CreateOffice::class);
        $this->registerService('FindOfficeById', FindOfficeById::class);
        $this->registerService('UpdateOffice', UpdateOffice::class);
        $this->registerService('DeleteOffice', DeleteOffice::class);
        $this->registerService('ShowRelatedUser', ShowRelatedUser::class);

        // MasterUser
        $this->registerService('CreateUser', CreateUser::class);
        $this->registerService('UpdateUser', UpdateUser::class);
        $this->registerService('DeleteUser', DeleteUser::class);

        // Master QR
        $this->registerService('CreateQR', CreateQR::class);
        $this->registerService('QrProcessing', QrProcessing::class);
        $this->registerService('ResetQrLimitByQrId', ResetQrLimitByQrId::class);
        $this->registerService('ResetAllUserQr', ResetAllUserQr::class);
        $this->registerService('UpdateQR', UpdateQR::class);

        // Application Configuration
        $this->registerService('CreateApplicationSetting', CreateApplicationSetting::class);
        $this->registerService('UpdateApplicationSetting', UpdateApplicationSetting::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerService($serviceName, $className) {
        $this->app->singleton($serviceName, function() use ($className) {
            return new $className;
        });
    }
}
