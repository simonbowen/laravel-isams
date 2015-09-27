<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML\Hydrators;

use SimonBowen\IsamsDrivers\Entities\BoardingHouse;

class BoardingHouseHydrator {

    protected $boardingHouse;

    public function __construct(BoardingHouse $boardingHouse)
    {
        $this->boardingHouse = $boardingHouse;
    }

    public function hydrate(\SimpleXMLElement $data)
    {
        $entity = $this->boardingHouse->newInstance();

        $entity->setName( (string) $data->Name);
        $entity->setId( (int) $data->attributes()->id);
        $entity->setHousemasterId( (int) $data->attributes()->HouseMasterId);
        $entity->setCode( (string) $data->Code);
        $entity->setSex( (string) $data->Sex);

        return $entity;
    }

}