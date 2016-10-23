<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators;

use SimonBowen\IsamsDrivers\Entities\Contracts\Pupil as PupilEntity;
use SimonBowen\IsamsDrivers\Models\Pupil;

class PupilHydrator
{
    protected $entity;

    public function __construct(PupilEntity $entity)
    {
        $this->entity = $entity;
    }

    public function hydrate(Pupil $model)
    {
        $entity = $this->entity->newInstance();

        $entity->setId($model->getKey());
        $entity->setEmail($model->txtEmailAddress);
        $entity->setName($model->txtFullname);
        $entity->setSchoolCode($model->txtSchoolCode);
        $entity->setSchoolId($model->txtSchoolId);
        $entity->setUserCode($model->txtUserCode);
        $entity->setUserName($model->txtUsername);
        $entity->setTitle($model->txtTitle);
        $entity->setForename($model->txtForename);
        $entity->setSurname($model->txtSurname);
        $entity->setMiddlename($model->txtMiddleNames);
        $entity->setInitials($model->txtInitials);
        $entity->setPreferredName($model->txtPreName);
        $entity->setFullname($model->txtFullname);
        $entity->setGender($model->txtGender);
        $entity->setDOB($model->txtDOB);
        $entity->setBoardingHouse($model->txtBoardingHouse);
        $entity->setNCYear($model->intNCYear);
        $entity->setPupilType($model->txtType);
        $entity->setEnrolmentDate($model->txtEnrolmentDate);
        $entity->setEnrolmentTerm($model->txtEnrolmentTerm);
        $entity->setEnrolmentSchoolYear($model->intEnrolmentSchoolYear);

        return $entity;
    }
}
