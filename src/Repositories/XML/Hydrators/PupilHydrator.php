<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML\Hydrators;

use SimonBowen\IsamsDrivers\Entities\Contracts\Pupil;

class PupilHydrator {

    protected $entity;
    protected $pupilRepository;

    public function __construct(Pupil $entity)
    {
        $this->entity = $entity;
    }

    public function hydrate(\SimpleXMLElement $pupil)
    {
        /** @var Pupil $entity */
        $entity = $this->entity->newInstance();

        $entity->setId( (int) $pupil->attributes()->id);
        $entity->setEmail( (string) $pupil->EmailAddress);
        $entity->setName( (string) $pupil->Fullname);
        $entity->setSchoolCode( (string) $pupil->SchoolCode);
        $entity->setSchoolId( (string) $pupil->SchoolId);
        $entity->setUserCode( (string) $pupil->UserCode);
        $entity->setUserName( (string) $pupil->UserName);
        $entity->setTitle( (string) $pupil->Title);
        $entity->setForename( (string) $pupil->Forename);
        $entity->setSurname( (string) $pupil->Surname);
        $entity->setMiddlename( (string) $pupil->Middlename);
        $entity->setInitials( (string) $pupil->Initials);
        $entity->setPreferredName( (string) $pupil->Preferredname);
        $entity->setFullname( (string) $pupil->Fullname);
        $entity->setGender( (string) $pupil->Gender);
        $entity->setDOB( (string) $pupil->DOB);
        $entity->setBoardingHouse( (string) $pupil->BoardingHouse);
        $entity->setNCYear( (string) $pupil->NCYear);
        $entity->setPupilType( (string) $pupil->PupilType);
        $entity->setEnrolmentDate( (string) $pupil->EnrolmentDate);
        $entity->setEnrolmentTerm( (string) $pupil->EnrolmentTerm);
        $entity->setEnrolmentSchoolYear( (string) $pupil->EnrolmentSchoolYear);

        return $entity;
    }

}