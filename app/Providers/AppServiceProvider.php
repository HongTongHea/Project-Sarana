<?php

namespace App\Providers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Providers\HybridUserProvider;
use Illuminate\Support\Facades\Gate;
use App\Services\SalesReportService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SalesReportService::class, function ($app) {
            return new SalesReportService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define gates for each role
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manager', function ($user) {
            return $user->isManager();
        });

        Gate::define('cashier', function ($user) {
            return $user->isCashier();
        });

        Gate::define('customer', function ($user) {
            return $user->isCustomer();
        });
    }
}
