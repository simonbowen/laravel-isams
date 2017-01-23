<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use Illuminate\Support\Collection;
use SimonBowen\IsamsDrivers\Repositories\Contracts\SetRepository as SetRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\SetNotFound;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator;
use SimonBowen\IsamsDrivers\XML\Loader;

class SetRepository extends BaseRepository implements SetRepositoryContract
{
    protected $setHydrator;
    protected $staffHydrator;
    protected $pupilHydrator;

    /**
     * @param Loader        $loader
     * @param SetHydrator   $setHydrator
     * @param StaffHydrator $staffHydrator
     * @param PupilHydrator $pupilHydrator
     */
    public function __construct(
        Loader $loader,
        SetHydrator $setHydrator,
        StaffHydrator $staffHydrator,
        PupilHydrator $pupilHydrator
    ) {
        $this->setHydrator = $setHydrator;
        $this->staffHydrator = $staffHydrator;
        $this->pupilHydrator = $pupilHydrator;
        parent::__construct($loader);
    }

    /**
     * @param $id
     *
     * @throws SetNotFound
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Set
     */
    public function getById($id)
    {
        $set = $this->xml->xpath("/iSAMS/Sets/Set[@Id={$id}]");

        if (!isset($set[0])) {
            throw new SetNotFound("Set not found with ID {$id}");
        }

        return $this->hydrate($set[0]);
    }

    public function getBySetCode($code)
    {
        $set = $this->xml->xpath("/iSAMS/Sets/Set[SetCode = '{$code}']");

        if (!isset($set[0])) {
            throw new SetNotFound("Set not found with Code {$code}");
        }

        return $this->hydrate($set[0]);
    }

    /**
     * @param $id
     *
     * @throws SetNotFound
     *
     * @return Collection
     */
    public function getTeachers($id)
    {
        $set = $this->getById($id);
        $teachers = new Collection();

        foreach ($set->getTeachers() as $id) {
            $staff = $this->xml->xpath("/iSAMS/CurrentStaff/StaffMember[@Id={$id}]");
            $teachers->push($this->staffHydrator->hydrate($staff[0]));
        }

        return $teachers;
    }

    /**
     * @param $id
     *
     * @return Collection
     */
    public function getPupils($id)
    {
        $setLists = $this->xml->xpath("/iSAMS/SetLists/SetList[@SetId={$id}]");
        $pupils = new Collection();

        foreach ($setLists as $setList) {
            $set = simplexml_import_dom($setList);
            $pupilId = $set->attributes()->PupilId;
            $pupil = $this->xml->xpath("/iSAMS/CurrentPupils/Pupil[@Id={$pupilId}]")[0];
            $pupils->push($this->pupilHydrator->hydrate($pupil));
        }

        return $pupils;
    }

    /**
     * @param $id
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     */
    public function getPrimaryTeacher($id)
    {
        $primary = $this->xml->xpath("/iSAMS/Sets/Set[@Id={$id}]/Teachers/Teacher[@PrimaryTeacher='True']")[0];
        $primary = simplexml_import_dom($primary);

        $staff = $this->xml->xpath("/iSAMS/CurrentStaff/StaffMember[@Id={$primary->attributes()->StaffId}]");

        return $this->staffHydrator->hydrate($staff[0]);
    }

    /**
     * @return Collection
     */
    public function all()
    {
        $sets = $this->xml->xpath('/iSAMS/Sets/Set');

        return $this->hydrateAll($sets);
    }

    /**
     * @param $sets
     *
     * @return Collection
     */
    private function hydrateAll($sets)
    {
        $collection = new Collection();
        foreach ($sets as $set) {
            $collection->push($this->hydrate($set));
        }

        return $collection;
    }

    /**
     * @param $set
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Set
     */
    private function hydrate($set)
    {
        return $this->setHydrator->hydrate($set);
    }
}
