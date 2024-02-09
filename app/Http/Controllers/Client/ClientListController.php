<?php

namespace App\Http\Controllers\Client;

use App\Src\DTOs\ClientDTO;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Request;
use App\Src\UseCases\ListClient;
use Inertia\Inertia;

class ClientListController extends Controller
{
    protected $listClient;

    public function __construct(ListClient $listClient)
    {
        $this->listClient = $listClient;
    }


    public function index()
    {
        $clients = $this->listClient->execute(Request::input('search'));
        return Inertia::render('Clients/ListClients', [
            "clients" => $clients,
            'filters' => Request::only(['search'])
        ]);
    }
}
