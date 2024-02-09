<?php

namespace App\Providers;

use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Observers\DepositObserver;
use App\Observers\WithdrawalsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Deposit::observe(DepositObserver::class);
        Withdrawal::observe(WithdrawalsObserver::class);
    }
}
