<?php

namespace SimonBowen\IsamsDrivers\Entities\Contracts;

interface Staff {

    public function getId();

    public function setId($id);

    public function getEmail();

    public function setEmail($email);

    public function getName();

    public function setName($name);

    public function getInitials();

    public function setInitials($initials);

    public function getUserCode();

    public function setUserCode($userCode);

    public function getTitle();

    public function setTitle($title);

    public function getForename();

    public function setForename($forename);

    public function getMiddleNames();

    public function setMiddleNames($middleNames);

    public function getSurname();

    public function setSurname($surname);

    public function getNameInitials();

    public function setNameInitials($nameInitials);

    public function getPreferredName();

    public function setPreferredName($preferredName);

    public function getSalutation();

    public function setSalutation($salutation);

    public function getDOB();

    public function setDOB($dob);

    public function getGender();

    public function setGender($gender);

}