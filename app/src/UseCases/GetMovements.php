<?php

namespace App\Src\UseCases;

use App\Models\Account;
use App\Src\Repositories\AccountRepositoryInterface;

class GetMovements
{
    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(Account $account)
    {
        return $this->accountRepository->movements($account);
    }
}
