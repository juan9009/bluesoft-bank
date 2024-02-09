<?php

namespace App\Src\DTOs;

class WithdrawalsDTO
{
    private $uuid;
    private $account_uuid;
    private $amount;

    public function __construct($account_uuid, $amount, $uuid = null)
    {
        $this->uuid = $uuid;
        $this->account_uuid = $account_uuid;
        $this->amount = $amount;
    }

    public function getId()
    {
        return $this->uuid ?: null;
    }

    public function getAccountUuid()
    {
        return $this->account_uuid;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}
