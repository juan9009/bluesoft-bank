<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Src\UseCases\DepositarDinero;
use App\Src\UseCases\GetTransactionsClients;
use Inertia\Inertia;

class TransactionsClientsController extends Controller
{
    protected $getTransactions;

    public function __construct(GetTransactionsClients $getTransactions)
    {
        $this->getTransactions = $getTransactions;
    }


    public function index(Request $request)
    {
        $month = $request->input('month');
        $clients = [];
        if (!$request->has('month') || $request->input('month') == null) {
            $month = null;
        } else {
            $month = $request->input('month');
            $clients = $this->getTransactions->execute($month);
        }

        return Inertia::render('Clients/Transactions', ['clients' => $clients, 'month' => $month]);
    }
}
