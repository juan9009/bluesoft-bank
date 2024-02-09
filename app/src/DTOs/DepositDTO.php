<?php

namespace App\Src\DTOs;

class DepositDTO
{
    private $uuid;
    private $account_uuid;
    private $amount;
    private $city;

    public function __construct($account_uuid, $amount, $city, $uuid = null)
    {
        $this->uuid = $uuid;
        $this->account_uuid = $account_uuid;
        $this->amount = $amount;
        $this->city = $city;
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

    public function getCity()
    {
        return $this->city;
    }
}
