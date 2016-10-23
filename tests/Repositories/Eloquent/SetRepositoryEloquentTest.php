<?php

use Mockery as m;

class SetRepositoryEloquentTest extends BaseTest
{
    protected function generateSet()
    {
        $faker = Faker\Factory::create();
        $set = new \SimonBowen\IsamsDrivers\Models\Set();

        $setName = $faker->word;

        $set->TblTeachingManagerSetsID = $faker->randomNumber();
        $set->txtName = $setName;
        $set->txtSetCode = $setName;
        $set->teachers = [];

        return $set;
    }

    public function getRepository($model)
    {
        $entity = new \SimonBowen\IsamsDrivers\Entities\Set();
        $hydrator = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\SetHydrator($entity);
        $staffHydrator = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\StaffHydrator(new \SimonBowen\IsamsDrivers\Entities\Staff());
        $pupilHydrator = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\PupilHydrator(new \SimonBowen\IsamsDrivers\Entities\Pupil());
        $repository = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\SetRepository($model, $hydrator, $staffHydrator, $pupilHydrator);

        return $repository;
    }

    public function getData()
    {
        $models = new \Illuminate\Support\Collection();
        for ($x = 0; $x < 5; $x++) {
            $models->push($this->generateSet());
        }

        return $models;
    }

    public function test_get_all_sets()
    {
        $model = m::mock(\SimonBowen\IsamsDrivers\Models\Set::class);
        $model->shouldReceive('all')->once()->andReturn($this->getData());

        $repository = $this->getRepository($model);
        $sets = $repository->all();

        $this->assertEquals(count($sets), 5);
    }

    public function test_get_set_by_id()
    {
        $id = 1001;
        $set = $this->generateSet();

        $model = m::mock(\SimonBowen\IsamsDrivers\Models\Set::class);
        $model->shouldReceive('find')->once()->andReturn($set);

        $repository = $this->getRepository($model);
        $entity = $repository->getById($id);

        $this->assertInstanceOf('SimonBowen\IsamsDrivers\Entities\Set', $entity);
        $this->assertEquals($set->getKey(), $entity->getId());
    }
}
