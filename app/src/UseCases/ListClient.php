<?php

namespace App\Src\UseCases;

use App\Src\Repositories\ClientRepositoryInterface;

class ListClient
{
    private $clientRepositoryInterface;

    public function __construct(ClientRepositoryInterface $clientRepositoryInterface)
    {
        $this->clientRepositoryInterface = $clientRepositoryInterface;
    }

    public function execute($search = null)
    {
        return $this->clientRepositoryInterface->all($search);
    }
}
