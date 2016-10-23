<?php

namespace SimonBowen\IsamsDrivers\Entities\Contracts;

interface BoardingHouse
{
    public function getName();

    public function setName($name);

    public function getId();

    public function setId($id);

    public function getHousemasterId();

    public function setHousemasterId($id);

    public function getSex();

    public function setSex($sex);

    public function getCode();

    public function setCode($code);
}
