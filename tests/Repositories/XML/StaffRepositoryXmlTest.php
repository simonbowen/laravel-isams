<?php

use Mockery as m;

class StaffRepositoryTest extends BaseTest {

    public function getRepository()
    {
        $loader = m::mock(SimonBowen\IsamsDrivers\XML\Loader::class);
        $loader->shouldReceive('get')
            ->andReturn(simplexml_load_file('./tests/data.xml'));

        $staffEntity = new \SimonBowen\IsamsDrivers\Entities\Staff();
        $staffHydrator = new \SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator($staffEntity);

        $setEntity = new \SimonBowen\IsamsDrivers\Entities\Set();
        $setHydrator = new \SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator($setEntity);

        $staffRepository = new \SimonBowen\IsamsDrivers\Repositories\XML\StaffRepository($loader, $staffHydrator, $setHydrator);

        return $staffRepository;
    }

    public function test_get_all_staff_members()
    {
        $staffRepository = $this->getRepository();

        $members = $staffRepository->all();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $members);

        $first = $members->first();
        $this->assertEquals($first->getId(), 1);
        $this->assertEquals($first->getName(), 'Simon Bowen');
        $this->assertEquals($first->getEmail(), 'sbowen@isams.com');

        $last = $members->last();
        $this->assertEquals($last->getId(), 3);
        $this->assertEquals($last->getName(), 'Damien Alborn');
        $this->assertEquals($last->getEmail(), 'dalborn@isams.com');
    }

    public function test_get_staff_member_by_id()
    {
        $staffRepository = $this->getRepository();
        $staff = $staffRepository->getById(1);

        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Staff', $staff);
        $this->assertEquals($staff->getId(), 1);
    }

    public function test_get_staff_member_by_email()
    {
        $staffRepository = $this->getRepository();
        $staff = $staffRepository->getByEmail('sbowen@isams.com');

        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Staff', $staff);
        $this->assertEquals($staff->getId(), 1);
    }

    public function test_get_sets_teacher()
    {
        $repository = $this->getRepository();
        $sets = $repository->getSets(1);

        $this->assertEquals(count($sets), 3);
        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Set', $sets[0]);
    }

}