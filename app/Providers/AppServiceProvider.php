<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('UserService', \App\Services\Domain\UserService::class);
        $this->app->bind('MicroPcRequest', \App\Services\Domain\MicroPcService::class);
        $this->app->bind('LineService', \App\Services\Domain\LineService::class);
        $this->app->bind('DepartmentService', \App\Services\Domain\DepartmentService::class);
        $this->app->bind('FileService', \App\Services\Inf\FileService::class);
        $this->app->bind('PlayFileService', \App\Services\Domain\PlayFileService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Passport::routes();
    }
}
