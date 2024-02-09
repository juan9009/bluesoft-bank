<?php

namespace App\Observers;

use App\Models\Withdrawal;
use App\Models\Account;

class WithdrawalsObserver
{
    /**
     * Handle the Deposit "created" event.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return void
     */
    public function created(Withdrawal $withdrawal)
    {
        $account = Account::where('uuid', $withdrawal->account_uuid)->first();
        $operation = $account->balance - $withdrawal->amount;
        $account->balance = ($operation < 0) ? 0 : $operation;
        $account->save();
    }
}
