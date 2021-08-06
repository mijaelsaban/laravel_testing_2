<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TransactionServiceInterface;
use App\Services\TransactionDbServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(
            TransactionServiceInterface::class,
            TransactionDbServiceInterface::class
        );
    }
}
