<?php

namespace App\Src\DTOs;

class AccountDTO
{
    private $uuid;
    private $client_uuid;
    private $account_number;
    private $type;
    private $balance;
    private $city;

    public function __construct($client_uuid, $account_number, $type, $city, $balance = 0, $uuid = null)
    {
        $this->uuid = $uuid;
        $this->client_uuid = $client_uuid;
        $this->account_number = $account_number;
        $this->type = $type;
        $this->balance = $balance;
        $this->city = $city;
    }

    public function getId()
    {
        return $this->uuid ?: null;
    }

    public function getClientUuid()
    {
        return $this->client_uuid;
    }

    public function getAccountNumer()
    {
        return $this->account_number;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getBalance()
    {
        return $this->balance ?: 0;
    }

    public function getCity()
    {
        return $this->city;
    }
}
