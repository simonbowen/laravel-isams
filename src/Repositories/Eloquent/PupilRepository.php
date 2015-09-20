<?php

namespace SimonBowen\IsamsDrivers\Repositories\Eloquent;

use Illuminate\Support\Collection;

use SimonBowen\IsamsDrivers\Repositories\Contracts\PupilRepository as PupilRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\PupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\PupilNotFound;
use SimonBowen\IsamsDrivers\Models\Pupil;

class PupilRepository implements PupilRepositoryContract {

    protected $pupilHydrator;

    /**
     * @param Pupil $model
     * @param PupilHydrator $pupilHydrator
     */
    public function __construct(Pupil $model, PupilHydrator $pupilHydrator)
    {
        $this->model = $model;
        $this->pupilHydrator = $pupilHydrator;
    }

    /**
     * @return Collection
     */
    public function all()
    {
        $pupils = $this->model->all();
        return $this->hydrateAll($pupils);
    }

    /**
     * @param $id
     * @return static
     * @throws PupilNotFound
     */
    public function getById($id)
    {
        $pupil = $this->model->find($id);

        if ( ! $pupil) {
            throw new PupilNotFound();
        }

        return $this->hydrate($pupil);
    }

    /**
     * @param $email
     * @return static
     * @throws PupilNotFound
     */
    public function getByEmail($email)
    {
        $pupil = $this->model->where('txtEmailAddress', $email)->first();

        if ( ! $pupil) {
            throw new PupilNotFound();
        }

        return $this->hydrate($pupil);
    }

    /**
     * @param Pupil $model
     * @return static
     */
    private function hydrate(Pupil $model)
    {
        return $this->pupilHydrator->hydrate($model);
    }

    /**
     * @param $pupils
     * @return Collection
     */
    private function hydrateAll($pupils)
    {
        $collection = new Collection();
        foreach ($pupils as $pupil) {
            $collection->push($this->hydrate($pupil));
        }
        return $collection;
    }

}