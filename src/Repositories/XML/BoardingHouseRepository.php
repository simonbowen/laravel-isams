<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use Illuminate\Support\Collection;

use SimonBowen\IsamsDrivers\Repositories\Exceptions\BoardingHouseNotFound;
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
        $houses = $this->xml->xpath("//iSAMS/SchoolManager/BoardingHouses/*");
        return $this->hydrateAll($houses);
    }

    public function getById($id)
    {
        $house = $this->xml->xpath("//iSAMS/SchoolManager/BoardingHouses/House[@id={$id}]");

        if ( ! isset($house[0])) {
            throw new BoardingHouseNotFound();
        }

        return $this->hydrate($house[0]);
    }

    public function getByHousemasterId($id)
    {
        $house = $this->xml->xpath("//iSAMS/SchoolManager/BoardingHouses/House[@HouseMasterId={$id}]");

        if ( ! isset($house[0])) {
            throw new BoardingHouseNotFound;
        }

        return $this->hydrate($house);
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