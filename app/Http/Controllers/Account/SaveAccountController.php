<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Src\DTOs\AccountDTO;
use Illuminate\Http\Request;
use App\Src\UseCases\SaveAccount;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class SaveAccountController extends Controller
{
    protected $saveAccount;

    public function __construct(SaveAccount $saveAccount)
    {
        $this->saveAccount = $saveAccount;
    }


    public function index(Client $client)
    {
        return Inertia::render(
            'Accounts/CreateAccount',
            [
                'client' => $client
            ]
        );
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'account_number' => 'required|unique:accounts',
            'city' => 'required|string|max:255',
            'type' => [
                'required',
                Rule::in(['savings', 'current'])
            ],

        ]);
        try {
            // Delega la lógica de negocio al caso de uso
            $client_uuid = $client->uuid;
            $city = $request->input('city');
            $type = $request->input('type');
            $account_number = $request->input('account_number');
            $clientDTO = new AccountDTO($client_uuid, $account_number, $type, $city);
            $this->saveAccount->execute($clientDTO);
            // Renderiza la página con un mensaje de éxito
            return Inertia::render('Accounts/CreateAccount', [
                'client' => $client,
                'success' => 'Account saved successfully!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
