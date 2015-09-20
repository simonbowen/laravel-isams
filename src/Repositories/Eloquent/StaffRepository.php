<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent;

use Illuminate\Support\Collection;

use SimonBowen\IsamsDrivers\Models\Staff;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\StaffHydrator;
use SimonBowen\IsamsDrivers\Repositories\Contracts\StaffRepository as StaffRepositoryContract;

class StaffRepository extends BaseRepository implements StaffRepositoryContract {

    protected $staffHydrator;

    public function __construct(Staff $model, StaffHydrator $staffHydrator)
    {
        $this->model = $model;
        $this->staffHydrator = $staffHydrator;
    }

    public function getById($id)
    {
        $member = $this->model->find($id);
        return $this->hydrate($member);
    }

    public function getByEmail($email)
    {
        $member = $this->model->where('SchoolEmailAddress', $email)->first();
        return $this->hydrate($member);
    }

    public function all()
    {
        $members = $this->model->all();
        return $this->hydrateAll($members);
    }

    public function getSets($id)
    {
        // TODO: Implement getSets() method.
    }

    private function hydrate(Staff $staff)
    {
        return $this->staffHydrator->hydrate($staff);
    }

    private function hydrateAll($members)
    {
        $collection = new Collection();
        foreach ($members as $member) {
            $collection->push($this->hydrate($member));
        }
        return $collection;
    }


}