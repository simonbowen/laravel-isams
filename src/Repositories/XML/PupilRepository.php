<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use Illuminate\Support\Collection;

use SimonBowen\IsamsDrivers\Repositories\Contracts\PupilRepository as PupilRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\PupilNotFound;
use SimonBowen\IsamsDrivers\XML\Loader;

class PupilRepository extends BaseRepository implements PupilRepositoryContract {

    protected $pupilHydrator;

    public function __construct(Loader $xml, PupilHydrator $pupilHydrator)
    {
        $this->pupilHydrator = $pupilHydrator;
        parent::__construct($xml);
    }

    /**
     * @return Collection
     */
    public function all()
    {
        $pupils = $this->xml->xpath("/iSAMS/PupilManager/CurrentPupils/*");
        return $this->hydrateAll($pupils);
    }

    /**
     * @param $id
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil
     * @throws PupilNotFound
     */
    public function getById($id)
    {
        $pupil = $this->xml->xpath("/iSAMS/PupilManager/CurrentPupils/Pupil[@id={$id}]");

        if ( ! isset($pupil[0])) {
            throw new PupilNotFound("Pupil not found with ID {$id}");
        }

        return $this->hydrate($pupil[0]);
    }

    /**
     * @param $email
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil
     * @throws PupilNotFound
     */
    public function getByEmail($email)
    {
        $pupil = $this->xml->xpath("/iSAMS/PupilManager/CurrentPupils/Pupil[EmailAddress = '{$email}']");

        if ( ! isset($pupil[0])) {
            throw new PupilNotFound("Pupil not found with Email {$email}");
        }

        return $this->hydrate($pupil[0]);
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

    /**
     * @param $pupil
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil
     */
    private function hydrate($pupil)
    {
        return $this->pupilHydrator->hydrate($pupil);
    }


}