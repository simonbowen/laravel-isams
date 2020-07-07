<?php

use Mockery as m;
use SimonBowen\IsamsDrivers\Repositories\XML\BoardingHouseRepository;

class BoardingHouseRepositoryXmlTest extends BaseTest
{
    public function getRepository()
    {
        $manager = new \SimonBowen\IsamsDrivers\XML\Manager(file_get_contents('./tests/data.xml'));

        $loader = m::mock(SimonBowen\IsamsDrivers\XML\Loader::class);
        $loader->shouldReceive('get')
            ->andReturn($manager);

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

    public function test_get_by_boarding_house_master()
    {
        $repository = $this->getRepository();

        /** @var \SimonBowen\IsamsDrivers\Entities\Contracts\BoardingHouse $house */
        $house = $repository->getByHousemasterId(223);

        $this->assertNotEmpty($house);
    }

    public function test_get_by_boarding_assistant_house_master()
    {
        $repository = $this->getRepository();

        /** @var \SimonBowen\IsamsDrivers\Entities\Contracts\BoardingHouse $house */
        $house = $repository->getByAssistantHousemasterId(326);

        $this->assertNotEmpty($house);
    }

    /**
     * @throws \SimonBowen\IsamsDrivers\Repositories\Exceptions\BoardingHouseNotFound
     *
     */
    public function test_pupil_not_found_exception()
    {
        $this->expectException(\SimonBowen\IsamsDrivers\Repositories\Exceptions\BoardingHouseNotFound::class);
        $repository = $this->getRepository();
        $house = $repository->getById(1000);
    }
}
