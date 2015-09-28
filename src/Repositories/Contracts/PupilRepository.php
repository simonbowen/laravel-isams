<?php

namespace SimonBowen\IsamsDrivers\Repositories\Contracts;

interface PupilRepository {

    public function all();

    public function getById($id);

    public function getByEmail($email);

    public function getByBoardingHouse($house);

}