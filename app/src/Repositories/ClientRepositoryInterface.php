<?php

namespace App\Src\Repositories;

use App\Models\Client;
use App\Src\DTOs\ClientDTO;

interface ClientRepositoryInterface
{
    public function all($search = null);
    public function find($id);
    public function save(ClientDTO $clientDto);
    public function movements();
    public function transactions($month);
    public function outTownWithdrawal();
}
