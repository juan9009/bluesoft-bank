<?php

namespace App\Src\DTOs;

class ClientDTO
{
    private $uuid;
    private $name;
    private $city;
    private $type;

    public function __construct($name, $city, $type, $uuid = null)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->city = $city;
        $this->type = $type;
    }

    public function getId()
    {
        return $this->uuid ?: null;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getType()
    {
        return $this->type;
    }
}
