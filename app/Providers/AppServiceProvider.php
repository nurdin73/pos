<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        $this->app->singleton('PenjualanService', \App\Services\PenjualanService::class);
        $this->app->singleton('PembelianService', \App\Services\PembelianService::class);
        $this->app->singleton('DashboardService', \App\Services\DashboardService::class);
        $this->app->singleton('SuplierService', \App\Services\SuplierService::class);
        $this->app->singleton('BranchStoreService', \App\Services\BranchStoreService::class);
        $this->app->singleton('TaxService', \App\Services\TaxService::class);
        $this->app->singleton('StaffService', \App\Services\StaffService::class);
        $this->app->singleton('DatabaseService', \App\Services\DatabaseService::class);
        $this->app->singleton('RoleService', \App\Services\RoleService::class);
        $this->app->singleton('RoleAccessService', \App\Services\RoleAccessService::class);
        $this->app->singleton('SubMenuService', \App\Services\SubMenuService::class);
        $this->app->singleton('LoyalityService', \App\Services\LoyalityService::class);
        $this->app->singleton('ReturnProductService', \App\Services\ReturnProductService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
