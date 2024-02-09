<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Src\DTOs\AccountDTO;
use App\Src\UseCases\ClientAccountList;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class ClientAccountsListController extends Controller
{
    protected $clientAccountList;

    public function __construct(ClientAccountList $clientAccountList)
    {
        $this->clientAccountList = $clientAccountList;
    }


    public function index(Client $client)
    {
        $accounts = $this->clientAccountList->execute($client);
        return Inertia::render(
            'Accounts/ClientAccountsList',
            [
                'client' => $client,
                'accounts' => $accounts
            ]
        );
    }
}
