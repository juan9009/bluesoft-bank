<?php

namespace App\Src\UseCases;

use App\Src\DTOs\DepositDTO;
use App\Src\Repositories\DepositRepositoryInterface;

class SaveDeposit
{
    private $depositRepository;

    public function __construct(DepositRepositoryInterface $depositRepository)
    {
        $this->depositRepository = $depositRepository;
    }

    public function execute(DepositDTO $depositDTO)
    {
        return $this->depositRepository->save($depositDTO);
    }
}
