<?php

namespace SimonBowen\IsamsDrivers\Entities;

use SimonBowen\IsamsDrivers\Entities\Contracts\Staff as StaffContract;

class Staff implements StaffContract
{
    protected $id;
    protected $name;
    protected $email;
    protected $initials;
    protected $userCode;
    protected $title;
    protected $forename;
    protected $middleNames;
    protected $surname;
    protected $nameInitials;
    protected $preferredName;
    protected $salutation;
    protected $dob;
    protected $gender;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getInitials()
    {
        return $this->initials;
    }

    public function setInitials($initials)
    {
        $this->initials = $initials;

        return $this;
    }

    public function getUserCode()
    {
        return $this->userCode;
    }

    public function setUserCode($userCode)
    {
        $this->userCode = $userCode;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getForename()
    {
        return $this->forename;
    }

    public function setForename($forename)
    {
        $this->forename = $forename;

        return $this;
    }

    public function getMiddleNames()
    {
        return $this->middleNames;
    }

    public function setMiddleNames($middleNames)
    {
        $this->middleNames = $middleNames;

        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    public function getNameInitials()
    {
        return $this->nameInitials;
    }

    public function setNameInitials($nameInitials)
    {
        $this->nameInitials = $nameInitials;

        return $this;
    }

    public function getPreferredName()
    {
        return $this->preferredName;
    }

    public function setPreferredName($preferredName)
    {
        $this->preferredName = $preferredName;

        return $this;
    }

    public function getSalutation()
    {
        return $this->salutation;
    }

    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getDOB()
    {
        return $this->dob;
    }

    public function setDOB($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    public function newInstance()
    {
        return new static();
    }
}
