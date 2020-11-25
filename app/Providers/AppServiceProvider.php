<?php

namespace App\Providers;

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
        $this->app->singleton('ProductsService', \App\Services\ProductsService::class);
        $this->app->singleton('UploadService', \App\Services\UploadService::class);
        $this->app->singleton('CategoriesService', \App\Services\CategoriesService::class);
        $this->app->singleton('CustomerService', \App\Services\CustomerService::class);
        $this->app->singleton('KasbonService', \App\Services\KasbonService::class);
        $this->app->singleton('TransactionService', \App\Services\TransactionService::class);
        $this->app->singleton('SettingService', \App\Services\SettingService::class);
        $this->app->singleton('StockService', \App\Services\StockService::class);
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
}
