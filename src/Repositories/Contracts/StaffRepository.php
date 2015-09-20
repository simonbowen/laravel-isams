<?php

namespace SimonBowen\IsamsDrivers\Repositories\Contracts;

interface StaffRepository {

    public function getById($id);

    public function getByEmail($email);

    public function all();

    public function getSets($id);

}