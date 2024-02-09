<?php

namespace App\Observers;

use App\Models\Deposit;
use App\Models\Account;

class DepositObserver
{
    /**
     * Handle the Deposit "created" event.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return void
     */
    public function created(Deposit $deposit)
    {
        $account = Account::where('uuid', $deposit->account_uuid)->first();
        $account->balance += $deposit->amount;
        $account->save();
    }
}
