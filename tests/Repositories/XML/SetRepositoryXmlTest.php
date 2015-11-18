<?php

use Mockery as m;

class SetRepositoryXmlTest extends PHPUnit_Framework_TestCase {

    public function getRepository()
    {
        $manager = new \SimonBowen\IsamsDrivers\XML\Manager(file_get_contents('./tests/data.xml'));

        $loader = m::mock(SimonBowen\IsamsDrivers\XML\Loader::class);
        $loader->shouldReceive('get')
            ->andReturn($manager);

        $staffEntity = new \SimonBowen\IsamsDrivers\Entities\Staff();
        $staffHydrator = new \SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator($staffEntity);

        $pupilEntity = new \SimonBowen\IsamsDrivers\Entities\Pupil();
        $pupilHydrator = new \SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator($pupilEntity);

        $setEntity = new \SimonBowen\IsamsDrivers\Entities\Set();
        $setHydrator = new \SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator($setEntity);
        $setRepository = new \SimonBowen\IsamsDrivers\Repositories\XML\SetRepository($loader, $setHydrator, $staffHydrator, $pupilHydrator);

        return $setRepository;
    }

    public function test_get_by_id()
    {
        $repository = $this->getRepository();

        /** @var \SimonBowen\IsamsDrivers\Entities\Contracts\Set $set */
        $set = $repository->getById(1);

        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Set', $set);
        $this->assertEquals($set->getId(), 1);
        $this->assertEquals($set->getName(), 'SETCODE1');
        $this->assertEquals($set->getSetCode(), 'SETCODE1');
        $this->assertEquals(count($set->getTeachers()), 2);
        $this->assertEquals(7, $set->getYear());
    }

    public function test_get_pupils_for_set()
    {
        $repository = $this->getRepository();
        $pupils = $repository->getPupils(1);
        $this->assertEquals(count($pupils), 2);
    }

    public function test_get_teachers()
    {
        $repository = $this->getRepository();
        $teachers = $repository->getTeachers(1);
        $this->assertEquals(count($teachers), 2);
        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Staff', $teachers[0]);
        $this->assertEquals($teachers[0]->getId(), 1);
        $this->assertEquals($teachers[1]->getId(), 2);
    }

    public function test_get_primary_teacher()
    {
        $repository = $this->getRepository();
        $primaryTeacher = $repository->getPrimaryTeacher(1);
        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Staff', $primaryTeacher);
        $this->assertEquals($primaryTeacher->getId(), 1);
    }

}