<?php

namespace App\Src\Repositories;

use App\Models\Account;
use App\Src\DTOs\DepositDTO;

interface DepositRepositoryInterface
{
    public function save(DepositDTO $withdrawalsDTO);
    public function allByAccount(Account $client);
}
