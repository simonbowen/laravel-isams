<?php

namespace SimonBowen\IsamsDrivers\Entities;

use SimonBowen\IsamsDrivers\Entities\Contracts\Set as SetContract;

class Set implements SetContract {

    protected $id;
    protected $setCode;
    protected $name;
    protected $teachers = [];
    protected $year;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getSetCode()
    {
        return $this->setCode;
    }

    public function setSetCode($setCode)
    {
        $this->setCode = $setCode;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getTeachers()
    {
        return $this->teachers;
    }

    public function addTeacher($teacher)
    {
        $this->teachers[] = $teacher;
        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    public function newInstance()
    {
        return new static();
    }


}