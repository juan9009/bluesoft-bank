<?php

namespace App\Src\Providers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Src\DTOs\AccountDTO;
use App\Src\Repositories\AccountRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentAccountRepository implements AccountRepositoryInterface
{
    public function save(AccountDTO $accountDto)
    {
        $account = new Account();
        $account->client_uuid = $accountDto->getClientUuid();
        $account->account_number = $accountDto->getAccountNumer();
        $account->type = $accountDto->getType();
        $account->balance = $accountDto->getBalance();
        $account->city = $accountDto->getCity();
        $account->save();
    }

    public function allByClient(Client $client)
    {
        return $client->accounts()
            ->paginate(10);
    }

    public function movements(Account $account)
    {
        $deposits = DB::table('deposits')
            ->where('deposits.account_uuid', $account->uuid)
            ->select('deposits.*', DB::raw("'deposit' as type"));

        $withdrawals = DB::table('withdrawals')
            ->where('withdrawals.account_uuid', $account->uuid)
            ->select('withdrawals.*', DB::raw("'withdrawal' as type"));

        return $deposits->union($withdrawals)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
}
