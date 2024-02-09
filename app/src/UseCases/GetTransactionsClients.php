<?php

namespace App\Src\UseCases;

use App\Src\Repositories\ClientRepositoryInterface;

class GetTransactionsClients
{
    private $clientRepositoryInterface;

    public function __construct(ClientRepositoryInterface $clientRepositoryInterface)
    {
        $this->clientRepositoryInterface = $clientRepositoryInterface;
    }

    public function execute($month)
    {
        return $this->clientRepositoryInterface->transactions($month);
    }
}
