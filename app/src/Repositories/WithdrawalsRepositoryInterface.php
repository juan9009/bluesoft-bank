<?php

namespace App\Src\Repositories;

use App\Models\Account;
use App\Src\DTOs\WithdrawalsDTO;

interface WithdrawalsRepositoryInterface
{
    public function save(WithdrawalsDTO $withdrawalsDTO);
    public function allByAccount(Account $client);
}
