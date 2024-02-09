<?php

namespace App\Src\UseCases;

use App\Models\Client;
use App\Src\Repositories\AccountRepositoryInterface;

class ClientAccountList
{
    private $accountRepositoryInterface;

    public function __construct(AccountRepositoryInterface $accountRepositoryInterface)
    {
        $this->accountRepositoryInterface = $accountRepositoryInterface;
    }

    public function execute(Client $client)
    {
        return $this->accountRepositoryInterface->allByClient($client);
    }
}
