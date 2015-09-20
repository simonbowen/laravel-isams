<?php

namespace SimonBowen\IsamsDrivers\Repositories\Contracts;

interface SetRepository {

    public function getById($id);

    public function getTeachers($id);

    public function getPupils($id);

    public function getPrimaryTeacher($id);

    public function all();

}