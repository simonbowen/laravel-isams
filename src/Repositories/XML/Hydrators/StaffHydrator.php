<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML\Hydrators;

use SimonBowen\IsamsDrivers\Entities\Contracts\Staff;

class StaffHydrator {

    protected $entity;

    public function __construct(Staff $entity)
    {
        $this->entity = $entity;
    }

    public function hydrate(\DOMNode $data)
    {
        $data = simplexml_import_dom($data);

        /** @var Staff $entity */
        $entity = $this->entity->newInstance();

        $entity->setId( (int) $data->attributes()->id);
        $entity->setEmail( (string) $data->SchoolEmailAddress);
        $entity->setName( (string) $data->FullName);
        $entity->setInitials( (string) $data->Initials);
        $entity->setUserCode( (string) $data->UserCode);
        $entity->setTitle( (string) $data->Title);
        $entity->setForename( (string) $data->Forename);
        $entity->setMiddleNames( (string) $data->Middlenames);
        $entity->setSurname( (string) $data->Surname);
        $entity->setNameInitials( (string) $data->NameInitials);
        $entity->setPreferredName( (string) $data->PreferredName);
        $entity->setSalutation( (string) $data->Salutation);
        $entity->setDOB( (string) $data->DOB);
        $entity->setGender( (string) $data->Gender);

        return $entity;
    }

}