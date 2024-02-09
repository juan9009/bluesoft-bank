<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Src\DTOs\DepositDTO;
use Illuminate\Http\Request;
use App\Src\UseCases\SaveDeposit;
use Inertia\Inertia;

class SaveDepositController extends Controller
{
    protected $saveDeposit;

    public function __construct(SaveDeposit $saveDeposit)
    {
        $this->saveDeposit = $saveDeposit;
    }


    public function index(Account $account)
    {
        return Inertia::render(
            'Deposit/CreateDeposit',
            [
                'account' => $account
            ]
        );
    }

    public function store(Request $request, Account $account)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|not_in:0',
            'city' => 'required|string|max:255',

        ]);
        try {
            $amount = $request->input('amount');
            $city = $request->input('city');
            $depositDTO = new DepositDTO($account->uuid, $amount, $city);
            $this->saveDeposit->execute($depositDTO);
            return redirect()->route('accounts.list', [
                'client' => $account->client_uuid
            ])->with('success', 'Deposit saved successfully!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
