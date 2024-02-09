<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Src\DTOs\WithdrawalsDTO;
use Illuminate\Http\Request;
use App\Src\UseCases\SaveWithdrawal;
use Inertia\Inertia;

class SaveWithdrawalController extends Controller
{
    protected $saveWithdrawal;

    public function __construct(SaveWithdrawal $saveWithdrawal)
    {
        $this->saveWithdrawal = $saveWithdrawal;
    }


    public function index(Account $account)
    {
        return Inertia::render(
            'Withdrawal/CreateWithdrawal',
            [
                'account' => $account
            ]
        );
    }

    public function store(Request $request, Account $account)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|not_in:0',
        ]);
        try {
            $amount = $request->input('amount');
            $withdrawalsDTO = new WithdrawalsDTO($account->uuid, $amount);
            $this->saveWithdrawal->execute($withdrawalsDTO);
            return redirect()->route('accounts.list', [
                'client' => $account->client_uuid
            ])->with('success', 'Withdrawal saved successfully!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
