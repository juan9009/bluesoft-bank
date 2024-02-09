<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Src\UseCases\GetOuttownClients;
use Inertia\Inertia;

class GetOuttownClientsController extends Controller
{
    protected $getOuttownClients;

    public function __construct(GetOuttownClients $getOuttownClients)
    {
        $this->getOuttownClients = $getOuttownClients;
    }

    public function index(Request $request)
    {
        $clients = $this->getOuttownClients->execute();

        return Inertia::render('Clients/Outtown', ['clients' => $clients]);
    }
}
