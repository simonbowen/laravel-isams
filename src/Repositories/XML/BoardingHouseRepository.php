<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\BoardingHouseHydrator;
use SimonBowen\IsamsDrivers\Repositories\Contracts\BoardingHouseRepository as BoardingHouseRepositoryContract;
use SimonBowen\IsamsDrivers\XML\Loader;

class BoardingHouseRepository extends BaseRepository implements BoardingHouseRepositoryContract {

    protected $hydrator;

    public function __construct(Loader $xml, BoardingHouseHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
        parent::__construct($xml);
    }

    public function all()
    {
        $houses = $this->xml->xpath('//iSAMS/SchoolManager/BoardingHouses');
        return $this->hydrateAll($houses);
    }

    private function hydrateAll($boardingHouses) {
        $collection = new Collection();
        foreach ($boardingHouses as $house) {
            $collection->push($this->hydrate($house));
        }
        return $collection;
    }

    private function hydrate($boardingHouse)
    {
        return $this->hydrator->hydrate($boardingHouse);
    }


}