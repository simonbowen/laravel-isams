<?php

namespace SimonBowen\IsamsDrivers\Repositories\Contracts;

interface BoardingHouseRepository
{
    public function all();

    public function getById($id);

    public function getByHousemasterId($id);
}
