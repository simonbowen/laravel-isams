<?php

use Mockery as m;
use SimonBowen\IsamsDrivers\Models\Staff;

class StaffRepositoryEloquentTest extends BaseTest
{
    protected function getRepository(Staff $model)
    {
        $entity = new \SimonBowen\IsamsDrivers\Entities\Staff();
        $hydrator = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\StaffHydrator($entity);
        $repository = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\StaffRepository($model, $hydrator);

        return $repository;
    }

    public function generateStaff()
    {
        $faker = Faker\Factory::create();
        $staff = new Staff();

        $firstname = $faker->firstName;
        $surname = $faker->lastName;
        $title = $faker->title;

        $staff->TblStaffID = $faker->numberBetween(1, 1000);
        $staff->SchoolEmailAddress = $faker->email;
        $staff->Fullname = implode(' ', [$firstname, $surname]);
        $staff->Initials = implode('', [$firstname[0], $surname[0]]);
        $staff->User_Code = $faker->randomAscii;
        $staff->Title = $title;
        $staff->Firstname = $firstname;
        $staff->MiddleNames = $faker->firstName;
        $staff->Surname = $surname;
        $staff->NameInitials = implode(' ', [$firstname[0], $surname[0]]);
        $staff->PreferredName = implode(' ', [$firstname[0], $surname[0]]);
        $staff->Salutation = implode(' ', [$title, $surname]);
        $staff->DOB = $faker->date('Y-m-d').' 00:00:00.000';
        $staff->Gender = $faker->randomElement(['M', 'F']);

        return $staff;
    }

    protected function getData()
    {
        $models = new \Illuminate\Support\Collection();
        for ($x = 0; $x < 5; $x++) {
            $models->push($this->generateStaff());
        }

        return $models;
    }

    public function test_get_all_staff_members()
    {
        $model = m::mock(Staff::class);
        $model->shouldReceive('all')->once()->andReturn($this->getData());

        $repository = $this->getRepository($model);
        $members = $repository->all();

        $this->assertEquals(count($members), 5);
    }

    public function test_get_staff_member_by_id()
    {
        $id = 1001;
        $member = $this->generateStaff();

        $model = m::mock(Staff::class);
        $model->shouldReceive('find')->with($id)->once()->andReturn($member);

        $repository = $this->getRepository($model);
        $staff = $repository->getById($id);

        $this->assertInstanceOf('SimonBowen\IsamsDrivers\Entities\Staff', $staff);
        $this->assertEquals($member->getKey(), $staff->getId());
    }

    public function test_get_staff_member_by_email()
    {
        $member = $this->generateStaff();

        $model = m::mock(Staff::class);
        $model
            ->shouldReceive('where')
            ->with('SchoolEmailAddress', $member->SchoolEmailAddress)
            ->once()
            ->andReturn($model)
            ->shouldReceive('first')
            ->once()
            ->andReturn($member);

        $repository = $this->getRepository($model);
        $entity = $repository->getByEmail($member->SchoolEmailAddress);

        $this->assertInstanceOf('SimonBowen\IsamsDrivers\Entities\Staff', $entity);
        $this->assertEquals($member->getKey(), $entity->getId());
        $this->assertEquals($member->Fullname, $entity->getName());
    }
}
