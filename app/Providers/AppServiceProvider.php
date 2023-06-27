<?php

namespace App\Providers;

use App\Actions\Midtrans\GetTransactionSnapToken;
use App\Services\Auth\DoLogin;
use App\Services\Backend\Configuration\CheckoutTransaction;
use App\Services\Backend\Configuration\CreateApplicationSetting;
use App\Services\Backend\Configuration\UpdateApplicationSetting;
use App\Services\Backend\Configuration\UpdateInformationSetting;
use App\Services\Backend\FileStorage\StoreToFileStorage;
use App\Services\Backend\MasterOffice\CreateOffice;
use App\Services\Backend\MasterOffice\DeleteOffice;
use App\Services\Backend\MasterOffice\FindOfficeById;
use App\Services\Backend\MasterOffice\ShowRelatedUser;
use App\Services\Backend\MasterOffice\UpdateOffice;
use App\Services\Backend\MasterQR\CreateQR;
use App\Services\Backend\MasterQR\CreateQRVCard;
use App\Services\Backend\MasterQR\DeleteQR;
use App\Services\Backend\MasterQR\QrProcessing;
use App\Services\Backend\MasterQR\QrVcardProcessing;
use App\Services\Backend\MasterQR\ResetAllGeneralQr;
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
        // Actions
        $this->registerService('GetTransactionSnapToken', GetTransactionSnapToken::class);



        // End Actions



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
        $this->registerService('CreateQRVCard', CreateQRVCard::class);
        $this->registerService('QrProcessing', QrProcessing::class);
        $this->registerService('QrVcardProcessing', QrVcardProcessing::class);
        $this->registerService('ResetQrLimitByQrId', ResetQrLimitByQrId::class);
        $this->registerService('ResetAllGeneralQr', ResetAllGeneralQr::class);
        $this->registerService('ResetAllUserQr', ResetAllUserQr::class);
        $this->registerService('UpdateQR', UpdateQR::class);
        $this->registerService('DeleteQR', DeleteQR::class);

        // Application Configuration
        $this->registerService('CreateApplicationSetting', CreateApplicationSetting::class);
        $this->registerService('UpdateApplicationSetting', UpdateApplicationSetting::class);

        // Information Setting
        $this->registerService('UpdateInformationSetting', UpdateInformationSetting::class);
        $this->registerService('CheckoutTransaction', CheckoutTransaction::class);

        // FileStorage
        $this->registerService('StoreToFileStorage', StoreToFileStorage::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale(config('app.locale'));
        date_default_timezone_set(config('app.timezone'));
    }

    private function registerService($serviceName, $className) {
        $this->app->singleton($serviceName, function() use ($className) {
            return new $className;
        });
    }
}
