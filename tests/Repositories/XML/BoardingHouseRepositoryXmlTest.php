<?php

use Mockery as m;

use SimonBowen\IsamsDrivers\Repositories\XML\BoardingHouseRepository;

class BoardingHouseRepositoryXmlTest extends PHPUnit_Framework_TestCase {

    public function getRepository()
    {
        $loader = m::mock(SimonBowen\IsamsDrivers\XML\Loader::class);
        $loader->shouldReceive('get')
            ->andReturn(simplexml_load_file('./tests/data.xml'));

        $entity = new \SimonBowen\IsamsDrivers\Entities\BoardingHouse();
        $hydrator = new \SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\BoardingHouseHydrator($entity);
        $boardingHouseRepository = new BoardingHouseRepository($loader, $hydrator);

        return $boardingHouseRepository;
    }

    public function test_get_all_boarding_houses()
    {
        $repository = $this->getRepository();
        $houses = $repository->all();

        $this->assertEquals(count($houses), 2);
    }

    public function test_get_by_id()
    {
        $repository = $this->getRepository();

        /** @var \SimonBowen\IsamsDrivers\Entities\Contracts\BoardingHouse $house */
        $house = $repository->getById(4);

        $this->assertEquals(4, $house->getId(4));
        $this->assertEquals('Blue', $house->getName());
        $this->assertEquals(223, $house->getHousemasterId());
        $this->assertEquals('F', $house->getSex());
        $this->assertEquals('BL', $house->getCode());
    }

    /**
     * @throws \SimonBowen\IsamsDrivers\Repositories\Exceptions\BoardingHouseNotFound
     * @expectedException \SimonBowen\IsamsDrivers\Repositories\Exceptions\BoardingHouseNotFound
     */
    public function test_pupil_not_found_exception()
    {
        $repository = $this->getRepository();
        $house = $repository->getById(1000);
    }



}