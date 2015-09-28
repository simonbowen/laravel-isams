<?php

use Mockery as m;

class BoardingHouseRepositoryEloquentTest extends BaseTest {

    public function getRepository($model)
    {
        $entity = new \SimonBowen\IsamsDrivers\Entities\BoardingHouse();
        $hydrator = new \SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\BoardingHouseHydrator($entity);

        return new \SimonBowen\IsamsDrivers\Repositories\Eloquent\BoardingHouseRepository($model, $hydrator);
    }

    public function generateBoardingHouse()
    {
        $faker = Faker\Factory::create();
        $boardingHouse = new \SimonBowen\IsamsDrivers\Models\BoardingHouse();

        $boardingHouse->TblSchoolManagementHousesId = $faker->randomDigit;
        $boardingHouse->txtHouseName = $faker->word;
        $boardingHouse->txtHouseCode = $faker->randomLetter . $faker->randomLetter;
        $boardingHouse->txtHouseMaster = $faker->word;
        $boardingHouse->txtSex = $faker->randomElement(['M', 'F', 'U']);

        return $boardingHouse;
    }

    public function getData()
    {
        $models = new \Illuminate\Support\Collection();
        for($x=0; $x<5; $x++) {
            $models->push($this->generateBoardingHouse());
        }
        return $models;
    }

    public function test_get_all_boarding_houses()
    {

    }

    // TODO: Work out a way to create tests that work when hydrating an object that uses a related model


}