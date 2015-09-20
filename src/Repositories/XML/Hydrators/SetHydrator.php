<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML\Hydrators;

use SimonBowen\IsamsDrivers\Entities\Contracts\Set;

class SetHydrator {

    protected $entity;

    public function __construct(Set $entity)
    {
        $this->entity = $entity;
    }

    public function hydrate(\SimpleXMLElement $data)
    {
        /** @var Set $entity */
        $entity = $this->entity->newInstance();

        $entity->setId( (int) $data->attributes()->id);
        $entity->setName( (string) $data->Name);
        $entity->setSetCode( (string) $data->SetCode);

        if (count($data->Teachers->Teacher) > 0) {
            foreach ($data->Teachers->Teacher as $teacher) {
                $entity->addTeacher((int) $teacher->attributes()->StaffId);
            }
        }

        return $entity;
    }

}