<?php

namespace SimonBowen\IsamsDrivers\Entities\Contracts;

interface Pupil {

    public function getId();

    public function setId($id);

    public function getEmail();

    public function setEmail($email);

    public function getName();

    public function setName($name);

    public function getSchoolCode();

    public function setSchoolCode($schoolCode);

    public function getSchoolId();

    public function setSchoolId($schoolId);

    public function getUserCode();

    public function setUserCode($userCode);

    public function getUserName();

    public function setUserName($userName);

    public function getTitle();

    public function setTitle($title);

    public function getForename();

    public function setForename($foreName);

    public function getSurname();

    public function setSurname($surname);

    public function getMiddlename();

    public function setMiddlename($middlename);

    public function getInitials();

    public function setInitials($initials);

    public function getPreferredName();

    public function setPreferredName($preferredName);

    public function getFullname();

    public function setFullname($fullname);

    public function getGender();

    public function setGender($gender);

    public function getDOB();

    public function setDOB($dob);

    public function getBoardingHouse();

    public function setBoardingHouse($boardingHouse);

    public function getNCYear();

    public function setNCYear($NCYear);

    public function getPupilType();

    public function setPupilType($pupilType);

    public function getEnrolmentDate();

    public function setEnrolmentDate($enrolmentDate);

    public function getEnrolmentTerm();

    public function setEnrolmentTerm($enrolmentTerm);

    public function getEnrolmentSchoolYear();

    public function setEnrolmentSchoolYear($enrolmentSchoolYear);

}