<?php

namespace App\Src\Repositories;

use App\Models\Account;
use App\Models\Client;
use App\Src\DTOs\AccountDTO;

interface AccountRepositoryInterface
{
    public function save(AccountDTO $accountDto);
    public function allByClient(Client $client);
    public function movements(Account $account);
}
