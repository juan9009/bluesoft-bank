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
            'amount' => [
                'required',
                'numeric',
                'min:0',
                'not_in:0',
                function ($attribute, $value, $fail) use ($account) {
                    if ($account->balance < $value) {
                        $fail('Insufficient balance');
                    }
                },
            ],
            'city' => 'required|string|max:255',
        ]);
        if ($account->balance < $request->amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }
        try {
            $amount = $request->input('amount');
            $city = $request->input('city');
            $withdrawalsDTO = new WithdrawalsDTO($account->uuid, $amount, $city);
            $this->saveWithdrawal->execute($withdrawalsDTO);
            return redirect()->route('accounts.list', [
                'client' => $account->client_uuid
            ])->with('success', 'Withdrawal saved successfully!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
