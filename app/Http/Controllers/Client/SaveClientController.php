<?php

namespace App\Http\Controllers\Client;

use App\Src\DTOs\ClientDTO;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Src\UseCases\SaveClient;
use Inertia\Inertia;

class SaveClientController extends Controller
{
    protected $saveClient;

    public function __construct(SaveClient $saveClient)
    {
        $this->saveClient = $saveClient;
    }

    public function index()
    {
        return Inertia::render('Clients/CreateClient');
    }

    public function store(Request $request)
    {
        try {
            // Delega la lógica de negocio al caso de uso
            $name = $request->input('name');
            $city = $request->input('city');
            $type = $request->input('type');
            $clientDTO = new ClientDTO($name, $city, $type);
            $this->saveClient->execute($clientDTO);
            // Renderiza la página con un mensaje de éxito
            return Inertia::render('Clients/CreateClient', [
                'success' => 'Client saved successfully!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
