<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML\Hydrators;

use SimonBowen\IsamsDrivers\Entities\BoardingHouse;

class BoardingHouseHydrator {

    protected $boardingHouse;

    public function __construct(BoardingHouse $boardingHouse)
    {
        $this->boardingHouse = $boardingHouse;
    }

    public function hydrate(\DOMNode $data)
    {
        $data = simplexml_import_dom($data);
        $entity = $this->boardingHouse->newInstance();

        $entity->setName( (string) $data->Name);
        $entity->setId( (int) $data->attributes()->Id);
        $entity->setHousemasterId( (int) $data->attributes()->HouseMasterId);
        $entity->setCode( (string) $data->Code);
        $entity->setSex( (string) $data->Sex);

        return $entity;
    }

}