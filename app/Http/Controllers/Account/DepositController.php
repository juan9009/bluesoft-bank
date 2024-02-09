<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Src\UseCases\DepositMoney;

class DepositController extends Controller
{
    protected $depositarDinero;

    public function __construct(DepositMoney $depositarDinero)
    {
        $this->depositarDinero = $depositarDinero;
    }

    public function depositar(Request $request)
    {
        $this->depositarDinero->execute($request->input('account_id'), $request->input('amount'));

        return response()->json(['message' => 'Depósito realizado con éxito']);
    }
}
