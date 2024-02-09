<?php

namespace App\Src\UseCases;

use App\Src\DTOs\WithdrawalsDTO;
use App\Src\Repositories\WithdrawalsRepositoryInterface;

class SaveWithdrawal
{
    private $withdrawalsRepository;

    public function __construct(WithdrawalsRepositoryInterface $withdrawalsRepository)
    {
        $this->withdrawalsRepository = $withdrawalsRepository;
    }

    public function execute(WithdrawalsDTO $withdrawalsDTO)
    {
        return $this->withdrawalsRepository->save($withdrawalsDTO);
    }
}
