<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators;

use SimonBowen\IsamsDrivers\Entities\Contracts\Set as SetEntity;
use SimonBowen\IsamsDrivers\Models\Set;

class SetHydrator
{
    protected $entity;

    public function __construct(SetEntity $entity)
    {
        $this->entity = $entity;
    }

    public function hydrate(Set $model)
    {
        $entity = $this->entity->newInstance();

        $entity->setId($model->getKey());
        $entity->setName($model->txtName);
        $entity->setSetCode($model->txtSetCode);

        foreach ($model->teachers as $teacher) {
            $entity->addTeacher($teacher->id);
        }

        return $entity;
    }
}
