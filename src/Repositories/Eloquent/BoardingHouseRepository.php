<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent;

use Illuminate\Support\Collection;
use SimonBowen\IsamsDrivers\Models\BoardingHouse;
use SimonBowen\IsamsDrivers\Repositories\Contracts\BoardingHouseRepository as BoardingHouseRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\BoardingHouseHydrator;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\BoardingHouseNotFound;

class BoardingHouseRepository implements BoardingHouseRepositoryContract
{
    protected $model;
    protected $hydrator;

    public function __construct(
        BoardingHouse $model,
        BoardingHouseHydrator $hydrator
    ) {
        $this->model = $model;
        $this->hydrator = $hydrator;
    }

    public function all()
    {
        return $this->hydrateAll($this->model->all());
    }

    public function getById($id)
    {
        if (!$house = $this->model->find($id)) {
            throw new BoardingHouseNotFound();
        }

        return $this->hydrate($house);
    }

    public function getByHousemasterId($id)
    {
        $house = $this
            ->model
            ->select('TblSchoolManagementHouses.*')
            ->join('TblStaff', 'TblStaff.User_Code', '=', 'TblSchoolManagementHouses.txtHouseMaster')
            ->where('TblStaff.TblStaffID', '=', $id)
            ->get();

        if (!$house) {
            throw new BoardingHouseNotFound();
        }

        return $this->hydrate($house);
    }

    public function hydrate($model)
    {
        return $this->hydrator->hydrate($model);
    }

    private function hydrateAll($houses)
    {
        $collection = new Collection();
        foreach ($houses as $house) {
            $collection->push($this->hydrate($house));
        }

        return $collection;
    }
}
