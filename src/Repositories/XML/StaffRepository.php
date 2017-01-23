<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use Illuminate\Support\Collection;
use SimonBowen\IsamsDrivers\Repositories\Contracts\StaffRepository as StaffRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Exceptions\StaffNotFound;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator;
use SimonBowen\IsamsDrivers\XML\Loader;

class StaffRepository extends BaseRepository implements StaffRepositoryContract
{
    protected $staffHydrator;
    protected $setHydrator;

    public function __construct(
        Loader $loader,
        StaffHydrator $staffHydrator,
        SetHydrator $setHydrator
    ) {
        $this->staffHydrator = $staffHydrator;
        $this->setHydrator = $setHydrator;
        parent::__construct($loader);
    }

    /**
     * @param $id
     *
     * @throws StaffNotFound
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     */
    public function getById($id)
    {
        $staff = $this->xml->xpath("/iSAMS/CurrentStaff/StaffMember[@Id={$id}]");

        if (!isset($staff[0])) {
            throw new StaffNotFound("Staff with ID {$id} not found");
        }

        return $this->hydrate($staff[0]);
    }

    /**
     * @param $email
     *
     * @throws StaffNotFound
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     */
    public function getByEmail($email)
    {
        $email = strtolower($email);
        $staff = $this->xml->xpath("/iSAMS/CurrentStaff/StaffMember[php:functionString('strtolower', SchoolEmailAddress) = '{$email}']");

        if (!isset($staff[0])) {
            throw new StaffNotFound("Staff with Email {$email} not found");
        }

        return $this->hydrate($staff[0]);
    }

    /**
     * @return Collection
     */
    public function all()
    {
        $staff = $this->xml->xpath('/iSAMS/CurrentStaff/*');

        return $this->hydrateAll($staff);
    }

    /**
     * @param $id
     *
     * @return Collection
     */
    public function getSets($id)
    {
        $sets = $this->xml->xpath("/iSAMS/Sets/Set[Teachers/Teacher[@StaffId={$id}]]");
        $teacherSets = new Collection();

        foreach ($sets as $set) {
            $teacherSets->push($this->setHydrator->hydrate($set));
        }

        return $teacherSets;
    }

    /**
     * @param $members
     *
     * @return Collection
     */
    public function hydrateAll($members)
    {
        $collection = new Collection();
        foreach ($members as $member) {
            $entity = $this->hydrate($member);
            $collection->push($entity);
        }

        return $collection;
    }

    /**
     * @param \DOMNode $data
     *
     * @return \SimonBowen\IsamsDrivers\Entities\Contracts\Staff
     */
    private function hydrate(\DOMNode $data)
    {
        return $this->staffHydrator->hydrate($data);
    }
}
