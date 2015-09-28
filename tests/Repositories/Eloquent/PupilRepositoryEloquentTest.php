<?php

use Mockery as m;

class PupilRepositoryEloquentTest extends BaseTest {

    protected function generatePupil()
    {
        $faker = Faker\Factory::create();
        $pupil = new \SimonBowen\IsamsDrivers\Models\Pupil();

        $forename = $faker->firstName;
        $surname = $faker->lastName;

        $pupil->TblPupilManagementPupilsID = $faker->numberBetween(1);
        $pupil->txtEmailAddress = $faker->email;
        $pupil->txtName = implode(' ', [$forename, $surname]);
        $pupil->txtSchoolCode = $faker->numberBetween(10000, 99999);
        $pupil->txtSchoolId = $faker->numberBetween(100000000, 9999999999);
        $pupil->txtUserCode = implode(' ', [$forename, $surname]) . $faker->numberBetween(100000000, 9999999999);
        $pupil->txtUsername = $faker->word;
        $pupil->txtTitle = $faker->title;
        $pupil->txtForename = $forename;
        $pupil->txtSurname = $surname;
        $pupil->txtMiddleNames = $faker->firstName;
        $pupil->txtInitials = $forename[0] . ' ' . $surname[0];
        $pupil->txtPreName = $forename;
        $pupil->txtFullname = implode(' ', [$forename, $surname]);
        $pupil->txtGender = $faker->randomElement(['M', 'F']);
        $pupil->txtDOB = $faker->date() . ' 00:00:00.000';
        $pupil->txtBoardingHouse = $faker->word;
        $pupil->intNCYear = 1;
        $pupil->txtEnrolmentDate = $faker->date() . ' 00:00:00';
        $pupil->txtEnrolmentTerm = $faker->word;
        $pupil->intEnrolmentSchoolYear = $faker->year;

        return $pupil;
    }

    protected function getData()
    {
        $models = new \Illuminate\Support\Collection();
        for($x=0; $x<5; $x++) {
            $models->push($this->generatePupil());
        }
        return $models;
    }

    protected function getRepository($model)
    {
        $entity = new \SimonBowen\IsamsDrivers\Entities\Pupil();
        $hydrator = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\PupilHydrator($entity);
        return new \SimonBowen\IsamsDrivers\Repositories\Eloquent\PupilRepository($model, $hydrator);
    }

    public function test_get_all_pupils()
    {
        $model = m::mock(\SimonBowen\IsamsDrivers\Models\Pupil::class);
        $model->shouldReceive('all')->once()->andReturn($this->getData());

        $repository = $this->getRepository($model);
        $pupils = $repository->all();
        $this->assertEquals(count($pupils), 5);
    }

    public function test_get_by_id()
    {

        $pupil = $this->generatePupil();

        $model = m::mock(\SimonBowen\IsamsDrivers\Models\Pupil::class);
        $model->shouldReceive('find')->with(1)->andReturn($pupil);

        $repository = $this->getRepository($model);

        /** @var \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil $entity */
        $entity = $repository->getById(1);

        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Pupil', $entity);
        $this->assertEquals($entity->getId(), $pupil->getKey());
        $this->assertEquals($entity->getEmail(), $pupil->txtEmailAddress);
    }

    public function test_get_by_email()
    {
        $pupil = $this->generatePupil();

        $model = m::mock(\SimonBowen\IsamsDrivers\Models\Pupil::class);
        $model
            ->shouldReceive('where')
            ->with('txtEmailAddress', $pupil->txtEmailAddress)
            ->once()
            ->andReturn($model)
            ->shouldReceive('first')
            ->once()
            ->andReturn($pupil);

        $repository = $this->getRepository($model);
        $entity = $repository->getByEmail($pupil->txtEmailAddress);

        $this->assertInstanceOf('\SimonBowen\IsamsDrivers\Entities\Contracts\Pupil', $entity);
        $this->assertEquals($pupil->getKey(), $entity->getId());
        $this->assertEquals($pupil->txtFullname, $entity->getFullname());
    }

}