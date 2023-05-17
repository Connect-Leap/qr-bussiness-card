<?php

namespace App\Providers;

use App\Services\Auth\DoLogin;
use App\Services\Backend\MasterOffice\CreateOffice;
use App\Services\Backend\MasterOffice\FindOfficeById;
use App\Services\Backend\MasterOffice\UpdateOffice;
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
