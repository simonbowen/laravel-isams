<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use Illuminate\Support\Collection;

use SimonBowen\IsamsDrivers\Repositories\Contracts\StaffRepository as StaffRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\StaffNotFound;


class StaffRepository extends BaseRepository implements StaffRepositoryContract {

    protected $staffHydrator;
    protected $setHydrator;

    public function __construct(
        \SimpleXMLElement $xml,
        StaffHydrator $staffHydrator,
        SetHydrator $setHydrator
    )
    {
        $this->staffHydrator = $staffHydrator;
        $this->setHydrator = $setHydrator;
        parent::__construct($xml);
    }

    /**
     * @param $id
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     * @throws StaffNotFound
     */
    public function getById($id)
    {
        $staff = $this->xml->xpath("/iSAMS/HRManager/CurrentStaff/StaffMember[@id={$id}]");

        if ( ! isset($staff[0])) {
            throw new StaffNotFound("Staff with ID {$id} not found");
        }

        return $this->hydrate($staff[0]);
    }

    /**
     * @param $email
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     * @throws StaffNotFound
     */
    public function getByEmail($email)
    {
        $staff = $this->xml->xpath("/iSAMS/HRManager/CurrentStaff/StaffMember[SchoolEmailAddress = '{$email}']");

        if ( ! isset($staff[0])) {
            throw new StaffNotFound("Staff with Email {$email} not found");
        }

        return $this->hydrate($staff[0]);
    }

    /**
     * @return Collection
     */
    public function all()
    {
        $staff = $this->xml->xpath("/iSAMS/HRManager/CurrentStaff/*");
        return $this->hydrateAll($staff);
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getSets($id)
    {
        $sets = $this->xml->xpath("/iSAMS/TeachingManager/Sets/Set[Teachers/Teacher[@StaffId={$id}]]");
        $teacherSets = new Collection();

        foreach ($sets as $set) {
            $teacherSets->push($this->setHydrator->hydrate($set));
        }

        return $teacherSets;
    }

    /**
     * @param $members
     * @return Collection
     */
    public function hydrateAll($members) {
        $collection = new Collection();
        foreach ($members as $member) {
            $entity = $this->hydrate($member);
            $collection->push($entity);
        }
        return $collection;
    }

    /**
     * @param \SimpleXMLElement $data
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     */
    private function hydrate(\SimpleXMLElement $data)
    {
        return $this->staffHydrator->hydrate($data);
    }


}