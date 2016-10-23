<?php

namespace SimonBowen\IsamsDrivers\Entities;

use SimonBowen\IsamsDrivers\Entities\Contracts\BoardingHouse as BoardingHouseContract;

class BoardingHouse implements BoardingHouseContract
{
    protected $name;
    protected $id;
    protected $housemasterId;
    protected $code;
    protected $sex;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getHousemasterId()
    {
        return $this->housemasterId;
    }

    public function setHousemasterId($id)
    {
        $this->housemasterId = $id;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    public function newInstance()
    {
        return new static();
    }
}
