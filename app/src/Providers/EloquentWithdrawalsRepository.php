<?php

namespace App\Src\Providers;

use App\Models\Account;
use App\Models\Withdrawal;
use App\Src\DTOs\WithdrawalsDTO;
use App\Src\Repositories\WithdrawalsRepositoryInterface;

class EloquentWithdrawalsRepository implements WithdrawalsRepositoryInterface
{
    public function save(WithdrawalsDTO $accountDto)
    {
        $account = new Withdrawal();
        $account->account_uuid = $accountDto->getAccountUuid();
        $account->amount = $accountDto->getAmount();
        $account->city = $accountDto->getCity();
        $account->save();
    }

    public function allByAccount(Account $client)
    {
        return $client->accounts()
            ->paginate(10);
    }
}
