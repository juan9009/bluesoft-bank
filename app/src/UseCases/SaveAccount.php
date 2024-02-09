<?php

namespace App\Src\UseCases;

use App\Src\DTOs\AccountDTO;
use App\Src\Repositories\AccountRepositoryInterface;

class SaveAccount
{
    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(AccountDTO $accountDto)
    {
        return $this->accountRepository->save($accountDto);
    }
}
