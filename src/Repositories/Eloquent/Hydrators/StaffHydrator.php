<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators;

use SimonBowen\IsamsDrivers\Entities\Staff as StaffEntity;
use SimonBowen\IsamsDrivers\Models\Staff;

class StaffHydrator
{
    protected $entity;

    public function __construct(StaffEntity $entity)
    {
        $this->entity = $entity;
    }

    public function hydrate(Staff $model)
    {
        /** @var Staff $entity */
        $entity = $this->entity->newInstance();

        $entity->setId($model->getKey());
        $entity->setEmail($model->SchoolEmailAddress);
        $entity->setName($model->Fullname);
        $entity->setInitials($model->Initials);
        $entity->setUserCode($model->User_Code);
        $entity->setTitle($model->Title);
        $entity->setForename($model->Firstname);
        $entity->setMiddleNames($model->MiddleNames);
        $entity->setSurname($model->Surname);
        $entity->setNameInitials($model->NameInitials);
        $entity->setPreferredName($model->PreName);
        $entity->setSalutation($model->Salutation);
        $entity->setDOB($model->DOB);
        $entity->setGender($model->Sex);

        return $entity;
    }
}
