<?php

namespace App\Shared\Infrastructure\Providers;

use App\Batches\Infrastructure\Providers\BatchServiceProvider;
use App\Reports\Infrastructure\Providers\ReportServiceProvider;
use App\Transactions\Infrastructure\Providers\TransactionServiceProvider;
use App\Users\Infrastructure\Providers\UserServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(BatchServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(SharedServiceProvider::class);
        $this->app->register(TransactionServiceProvider::class);
        $this->app->register(ReportServiceProvider::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        setlocale(LC_TIME, 'es_ES');
        Carbon::setLocale('es');
    }
}
