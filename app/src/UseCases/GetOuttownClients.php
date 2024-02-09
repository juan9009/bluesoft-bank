<?php

namespace App\Src\UseCases;

use App\Src\Repositories\ClientRepositoryInterface;

class GetOuttownClients
{
    private $clientRepositoryInterface;

    public function __construct(ClientRepositoryInterface $clientRepositoryInterface)
    {
        $this->clientRepositoryInterface = $clientRepositoryInterface;
    }

    public function execute()
    {
        return $this->clientRepositoryInterface->outTownWithdrawal();
    }
}
