<?php

namespace App\Src\Providers;

use App\Models\Account;
use App\Models\Deposit;
use App\Src\DTOs\DepositDTO;
use App\Src\Repositories\DepositRepositoryInterface;

class EloquentDepositRepository implements DepositRepositoryInterface
{
    public function save(DepositDTO $depositDto)
    {
        $account = new Deposit();
        $account->account_uuid = $depositDto->getAccountUuid();
        $account->amount = $depositDto->getAmount();
        $account->save();
    }

    public function allByAccount(Account $client)
    {
        return $client->accounts()
            ->paginate(10);
    }
}
