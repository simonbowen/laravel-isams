<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent;

use Illuminate\Support\Collection;
use SimonBowen\IsamsDrivers\Models\Set;
use SimonBowen\IsamsDrivers\Repositories\Contracts\SetRepository as SetRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\PupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\SetHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\StaffHydrator;

class SetRepository extends BaseRepository implements SetRepositoryContract
{
    protected $setHydrator;
    protected $staffHydrator;
    protected $pupilHydrator;

    public function __construct(
        Set $model,
        SetHydrator $setHydrator,
        StaffHydrator $staffHydrator,
        PupilHydrator $pupilHydrator
    ) {
        $this->model = $model;
        $this->setHydrator = $setHydrator;
        $this->staffHydrator = $staffHydrator;
        $this->pupilHydrator = $pupilHydrator;
    }

    public function getById($id)
    {
        $set = $this->model->find($id);

        return $this->hydrate($set);
    }

    public function getBySetCode($code)
    {
        $set = $this->model->where('txtSetCode', $code)->first();

        return $this->hydrate($set);
    }

    public function getTeachers($id)
    {
        $set = $this->model->find($id);

        $teachers = $set->teachers;
        $collection = new Collection();

        foreach ($teachers as $teacher) {
            $collection->push($this->staffHydrator->hydrate($teacher));
        }

        $collection->push($this->getPrimaryTeacher($id));

        return $collection;
    }

    public function getPupils($id)
    {
        $pupils = $this->model->pupils;
        $collection = new Collection();

        foreach ($pupils as $pupil) {
            $collection->push($this->pupilHydrator->hydrate($pupil));
        }

        return $collection;
    }

    public function getPrimaryTeacher($id)
    {
        $primaryTeacher = $this->model->find($id)->primary_teacher;

        return $this->staffHydrator->hydrate($primaryTeacher);
    }

    public function all()
    {
        $sets = $this->model->all();

        return $this->hydrateAll($sets);
    }

    private function hydrate(Set $set)
    {
        return $this->setHydrator->hydrate($set);
    }

    private function hydrateAll($sets)
    {
        $collection = new Collection();
        foreach ($sets as $set) {
            $collection->push($this->hydrate($set));
        }

        return $collection;
    }
}
