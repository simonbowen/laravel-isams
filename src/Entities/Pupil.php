<?php

namespace SimonBowen\IsamsDrivers\Entities;

use SimonBowen\IsamsDrivers\Entities\Contracts\Pupil as PupilContract;

class Pupil implements PupilContract {

    protected $id;
    protected $email;
    protected $name;
    protected $schoolCode;
    protected $schoolId;
    protected $userCode;
    protected $userName;
    protected $title;
    protected $forename;
    protected $surname;
    protected $middlename;
    protected $fullname;
    protected $gender;
    protected $dob;
    protected $boardingHouse;
    protected $NCYear;
    protected $pupilType;
    protected $enrolmentDate;
    protected $enrolmentTerm;
    protected $enrolmentSchoolYear;
    protected $initials;
    protected $preferredName;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getSchoolCode()
    {
        return $this->schoolCode;
    }

    public function setSchoolCode($schoolCode)
    {
        $this->schoolCode = $schoolCode;
        return $this;
    }

    public function getSchoolId()
    {
        return $this->schoolId;
    }

    public function setSchoolId($schoolId)
    {
        $this->schoolId = $schoolId;
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

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
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

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    public function getMiddlename()
    {
        return $this->middlename;
    }

    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
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

    public function getPreferredName()
    {
        return $this->preferredName;
    }

    public function setPreferredName($preferredName)
    {
        $this->preferredName = $preferredName;
        return $this;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
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

    public function getDOB()
    {
        return $this->dob;
    }

    public function setDOB($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    public function getBoardingHouse()
    {
        return $this->boardingHouse;
    }

    public function setBoardingHouse($boardingHouse)
    {
        $this->boardingHouse = $boardingHouse;
        return $this;
    }

    public function getNCYear()
    {
        return $this->NCYear;
    }

    public function setNCYear($NCYear)
    {
        $this->NCYear = $NCYear;
        return $this;
    }

    public function getPupilType()
    {
        return $this->pupilType;
    }

    public function setPupilType($pupilType)
    {
        $this->pupilType = $pupilType;
        return $this;
    }

    public function getEnrolmentDate()
    {
        return $this->enrolmentDate;
    }

    public function setEnrolmentDate($enrolmentDate)
    {
        $this->enrolmentDate = $enrolmentDate;
        return $this;
    }

    public function getEnrolmentTerm()
    {
        return $this->enrolmentTerm;
    }

    public function setEnrolmentTerm($enrolmentTerm)
    {
        $this->enrolmentTerm = $enrolmentTerm;
        return $this;
    }

    public function getEnrolmentSchoolYear()
    {
        return $this->enrolmentSchoolYear;
    }

    public function setEnrolmentSchoolYear($enrolmentSchoolYear)
    {
        $this->enrolmentSchoolYear = $enrolmentSchoolYear;
        return $this;
    }

    public function newInstance()
    {
        return new static();
    }

}