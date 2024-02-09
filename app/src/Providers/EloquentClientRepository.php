<?php

namespace App\Src\Providers;

use App\Models\Client;
use App\Src\DTOs\ClientDTO;
use App\Src\Repositories\ClientRepositoryInterface;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function all($search = null)
    {
        return Client::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->OrWhere('city', 'like', '%' . $search . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(10);
        //->withQueryString()
    }

    public function find($id)
    {
    }

    public function save(ClientDTO $clientDto)
    {
        $account = new Client();
        $account->name = $clientDto->getName();
        $account->city = $clientDto->getCity();
        $account->type = $clientDto->getType();
        $account->save();
    }

    public function movements()
    {
    }

    public function transactions($month)
    {
        return Client::query()
            ->paginate(10);
    }
}
