<?php

namespace SimonBowen\IsamsDrivers\Entities\Contracts;

interface Set {

    public function getId();

    public function setId($id);

    public function getSetCode();

    public function setSetCode($setCode);

    public function getName();

    public function setName($name);

    public function getTeachers();

    public function addTeacher($teacher);

}