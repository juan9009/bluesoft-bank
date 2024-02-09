<?php

namespace App\Src\UseCases;

use App\Src\DTOs\ClientDTO;
use App\Src\Repositories\ClientRepositoryInterface;

class SaveClient
{
    private $clientRepositoryInterface;

    public function __construct(ClientRepositoryInterface $clientRepositoryInterface)
    {
        $this->clientRepositoryInterface = $clientRepositoryInterface;
    }

    public function execute(ClientDTO $clientDto)
    {
        return $this->clientRepositoryInterface->save($clientDto);
    }
}
