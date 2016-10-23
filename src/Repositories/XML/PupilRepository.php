<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use Illuminate\Support\Collection;
use SimonBowen\IsamsDrivers\Repositories\Contracts\PupilRepository as PupilRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\PupilNotFound;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator;
use SimonBowen\IsamsDrivers\XML\Loader;

class PupilRepository extends BaseRepository implements PupilRepositoryContract
{
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
        $pupils = $this->xml->xpath('/iSAMS/PupilManager/CurrentPupils/*');

        return $this->hydrateAll($pupils);
    }

    /**
     * @param $id
     *
     * @throws PupilNotFound
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil
     */
    public function getById($id)
    {
        $pupil = $this->xml->xpath("/iSAMS/PupilManager/CurrentPupils/Pupil[@Id={$id}]");

        if (!isset($pupil[0])) {
            throw new PupilNotFound("Pupil not found with ID {$id}");
        }

        return $this->hydrate($pupil[0]);
    }

    /**
     * @param $email
     *
     * @throws PupilNotFound
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil
     */
    public function getByEmail($email)
    {
        $email = strtolower($email);
        $pupil = $this->xml->xpath('/iSAMS/PupilManager/CurrentPupils/Pupil[php:functionString("strtolower", EmailAddress) = "'.$email.'"]');

        if (!isset($pupil[0])) {
            throw new PupilNotFound("Pupil not found with Email {$email}");
        }

        return $this->hydrate($pupil[0]);
    }

    /**
     * @param $house
     *
     * @return Collection
     */
    public function getByBoardingHouse($house)
    {
        $pupils = $this->xml->xpath("/iSAMS/PupilManager/CurrentPupils/Pupil[BoardingHouse = '{$house}']");

        return $this->hydrateAll($pupils);
    }

    /**
     * @param $pupils
     *
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
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil
     */
    private function hydrate(\DOMNode $pupil)
    {
        return $this->pupilHydrator->hydrate($pupil);
    }
}
