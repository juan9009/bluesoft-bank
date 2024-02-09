<?php

namespace App\Providers;

use App\Src\Providers\EloquentAccountRepository;
use App\Src\Providers\EloquentClientRepository;
use App\Src\Providers\EloquentDepositRepository;
use App\Src\Providers\EloquentWithdrawalsRepository;
use App\Src\Repositories\AccountRepositoryInterface;
use App\Src\Repositories\ClientRepositoryInterface;
use App\Src\Repositories\DepositRepositoryInterface;
use App\Src\Repositories\WithdrawalsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ResolverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AccountRepositoryInterface::class, EloquentAccountRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, EloquentClientRepository::class);
        $this->app->bind(WithdrawalsRepositoryInterface::class, EloquentWithdrawalsRepository::class);
        $this->app->bind(DepositRepositoryInterface::class, EloquentDepositRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
