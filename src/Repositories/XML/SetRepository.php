<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use Illuminate\Support\Collection;

use SimonBowen\IsamsDrivers\Repositories\Contracts\SetRepository as SetRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\SetNotFound;

class SetRepository extends BaseRepository implements SetRepositoryContract  {

    protected $setHydrator;
    protected $staffHydrator;
    protected $pupilHydrator;

    /**
     * @param \SimpleXMLElement $xml
     * @param SetHydrator $setHydrator
     * @param StaffHydrator $staffHydrator
     * @param PupilHydrator $pupilHydrator
     */
    public function __construct(
        \SimpleXMLElement $xml,
        SetHydrator $setHydrator,
        StaffHydrator $staffHydrator,
        PupilHydrator $pupilHydrator
    )
    {
        $this->setHydrator = $setHydrator;
        $this->staffHydrator = $staffHydrator;
        $this->pupilHydrator = $pupilHydrator;
        parent::__construct($xml);
    }

    /**
     * @param $id
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Set
     * @throws SetNotFound
     */
    public function getById($id)
    {
        $set = $this->xml->xpath("/iSAMS/TeachingManager/Sets/Set[@id={$id}]");

        if ( ! isset($set[0])) {
            throw new SetNotFound("Set not found with ID {$id}");
        }

        return $this->hydrate($set[0]);
    }

    /**
     * @param $id
     * @return Collection
     * @throws SetNotFound
     */
    public function getTeachers($id)
    {
        $set = $this->getById($id);
        $teachers = new Collection();

        foreach ($set->getTeachers() as $id) {
            $staff = $this->xml->xpath("/iSAMS/HRManager/CurrentStaff/StaffMember[@id={$id}]");
            $teachers->push($this->staffHydrator->hydrate($staff[0]));
        }

        return $teachers;
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getPupils($id)
    {
        $setLists = $this->xml->xpath("/iSAMS/TeachingManager/SetLists/SetList[@SetId={$id}]");
        $pupils = new Collection();

        foreach ($setLists as $setList) {
            $pupilId = $setList->attributes()->PupilId;
            $pupil = $this->xml->xpath("/iSAMS/PupilManager/CurrentPupils/Pupil[@id={$pupilId}]")[0];
            $pupils->push($this->pupilHydrator->hydrate($pupil));
        }

        return $pupils;
    }

    /**
     * @param $id
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     */
    public function getPrimaryTeacher($id)
    {
        $primary = $this->xml->xpath("/iSAMS/TeachingManager/Sets/Set[@id={$id}]/Teachers/Teacher[@PrimaryTeacher='True']")[0];
        $staff = $this->xml->xpath("/iSAMS/HRManager/CurrentStaff/StaffMember[@id={$primary->attributes()->StaffId}]");
        return $this->staffHydrator->hydrate($staff[0]);
    }

    /**
     * @return Collection
     */
    public function all()
    {
        $sets = $this->xml->xpath('/iSAMS/TeachingManager/Sets/Set');
        return $this->hydrateAll($sets);
    }

    /**
     * @param $sets
     * @return Collection
     */
    private function hydrateAll($sets) {
        $collection = new Collection();
        foreach ($sets as $set) {
            $collection->push($this->hydrate($set));
        }
        return $collection;
    }

    /**
     * @param $set
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Set
     */
    private function hydrate($set)
    {
        return $this->setHydrator->hydrate($set);
    }

}