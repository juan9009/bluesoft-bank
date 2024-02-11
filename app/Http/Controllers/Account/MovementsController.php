<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Src\UseCases\GetMovements;
use Inertia\Inertia;

class MovementsController extends Controller
{
    protected $getMovements;

    public function __construct(GetMovements $getMovements)
    {
        $this->getMovements = $getMovements;
    }

    public function index(Account $account, Request $request)
    {
        $month = null;
        if ($request->has('month')) {
            $month = $request->get('month');
        }
        // Delega la lógica de negocio al caso de uso
        $movements = $this->getMovements->execute($account, $month);

        // Devuelve una respuesta Inertia que renderiza el componente 'Movements' con los movements como prop
        //return Inertia::render('MovementsList', ['movements' => $movements]);

        // Devuelve una respuesta JSON con los movements
        return response()->json(['movements' => $movements]);
    }
}
