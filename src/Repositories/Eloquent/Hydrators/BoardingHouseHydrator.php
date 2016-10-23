<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators;

use SimonBowen\IsamsDrivers\Entities\Contracts\BoardingHouse as BoardingHouseEntity;
use SimonBowen\IsamsDrivers\Models\BoardingHouse;

class BoardingHouseHydrator
{
    protected $entity;

    public function __construct(BoardingHouseEntity $entity)
    {
        $this->entity = $entity;
    }

    public function hydrate(BoardingHouse $boardingHouse)
    {
        $entity = $this->entity->newInstance();

        $housemaster = $boardingHouse->getHousemaster();

        $entity->setName((string) $boardingHouse->txtHouseName);
        $entity->setCode((string) $boardingHouse->txtHouseCode);
        $entity->setSex((string) $boardingHouse->txtSex);
        $entity->setId((int) $boardingHouse->TblSchoolManagementHousesId);
        $entity->setHousemasterId((int) $housemaster->getKey());

        return $entity;
    }
}
