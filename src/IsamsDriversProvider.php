<?php

namespace SimonBowen\IsamsDrivers;

use Illuminate\Support\ServiceProvider;
use SimonBowen\IsamsDrivers\Entities\BoardingHouse as BoardingHouseEntity;
use SimonBowen\IsamsDrivers\Entities\Pupil as PupilEntity;
use SimonBowen\IsamsDrivers\Entities\Set as SetEntity;
use SimonBowen\IsamsDrivers\Entities\Staff as StaffEntity;
use SimonBowen\IsamsDrivers\Models\BoardingHouse;
use SimonBowen\IsamsDrivers\Models\Pupil;
use SimonBowen\IsamsDrivers\Models\Set;
use SimonBowen\IsamsDrivers\Models\Staff;
use SimonBowen\IsamsDrivers\Repositories\Contracts\BoardingHouseRepository as BoardingHouseRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Contracts\PupilRepository as PupilRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Contracts\SetRepository as SetRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Contracts\StaffRepository as StaffRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\BoardingHouseRepository as EloquentBoardingHouseRepository;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\BoardingHouseHydrator as EloquentBoardingHouseHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\PupilHydrator as EloquentPupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\SetHydrator as EloquentSetHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\StaffHydrator as EloquentStaffHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\PupilRepository as EloquentPupilRepository;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\SetRepository as EloquentSetRepository;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\StaffRepository as EloquentStaffRepository;
use SimonBowen\IsamsDrivers\Repositories\XML\BoardingHouseRepository as XmlBoardingHouseRepository;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\BoardingHouseHydrator as XmlBoardingHouseHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator as XmlPupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator as XmlSetHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator as XmlStaffHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\PupilRepository as XmlPupilRepository;
use SimonBowen\IsamsDrivers\Repositories\XML\SetRepository as XmlSetRepository;
use SimonBowen\IsamsDrivers\Repositories\XML\StaffRepository as XmlStaffRepository;
use SimonBowen\IsamsDrivers\XML\Loader;

class IsamsDriversProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/isams.php' => config_path('isams.php'),
        ]);
    }

    public function register()
    {
        $this->registerEntities();
        $driver = app('config')->get('isams.driver');
        if ($driver == 'xml') {
            $this->registerXml();
        } elseif ($driver == 'db') {
            $this->registerDb();
        }
    }

    public function registerEntities()
    {
        $this->app->bind(
            \SimonBowen\IsamsDrivers\Entities\Contracts\Staff::class,
            \SimonBowen\IsamsDrivers\Entities\Staff::class
        );

        $this->app->bind(
            \SimonBowen\IsamsDrivers\Entities\Contracts\Pupil::class,
            \SimonBowen\IsamsDrivers\Entities\Pupil::class
        );

        $this->app->bind(
            \SimonBowen\IsamsDrivers\Entities\Contracts\Set::class,
            \SimonBowen\IsamsDrivers\Entities\Set::class
        );

        $this->app->bind(
            \SimonBowen\IsamsDrivers\Entities\Contracts\BoardingHouse::class,
            \SimonBowen\IsamsDrivers\Entities\BoardingHouse::class
        );
    }

    public function registerXml()
    {
        $this->app->bind(PupilRepositoryContract::class, function () {
            return new XmlPupilRepository(
                new Loader(),
                new XmlPupilHydrator(app(\SimonBowen\IsamsDrivers\Entities\Contracts\Pupil::class))
            );
        });

        $this->app->bind(StaffRepositoryContract::class, function () {
            return new XmlStaffRepository(
                new Loader(),
                new XmlStaffHydrator(app(\SimonBowen\IsamsDrivers\Entities\Contracts\Staff::class)),
                new XmlSetHydrator(app(\SimonBowen\IsamsDrivers\Entities\Contracts\Set::class))
            );
        });

        $this->app->bind(SetRepositoryContract::class, function () {
            return new XmlSetRepository(
                new Loader(),
                new XmlSetHydrator(app(\SimonBowen\IsamsDrivers\Entities\Contracts\Set::class)),
                new XmlStaffHydrator(app(\SimonBowen\IsamsDrivers\Entities\Contracts\Staff::class)),
                new XmlPupilHydrator(app(\SimonBowen\IsamsDrivers\Entities\Contracts\Pupil::class))
            );
        });

        $this->app->bind(BoardingHouseRepositoryContract::class, function () {
            return new XmlBoardingHouseRepository(
                new Loader(),
                new XmlBoardingHouseHydrator(app(BoardingHouseEntity::class))
            );
        });
    }

    public function registerDb()
    {
        $this->app->bind(PupilRepositoryContract::class, function () {
            return new EloquentPupilRepository(
                new Pupil(),
                new EloquentPupilHydrator(app(\SimonBowen\IsamsDrivers\Entities\Contracts\Pupil::class))
            );
        });

        $this->app->bind(StaffRepositoryContract::class, function () {
            return new EloquentStaffRepository(
                new Staff(),
                new EloquentStaffHydrator(new StaffEntity())
            );
        });

        $this->app->bind(SetRepositoryContract::class, function () {
            return new EloquentSetRepository(
                new Set(),
                new EloquentSetHydrator(new SetEntity()),
                new EloquentStaffHydrator(new StaffEntity()),
                new EloquentPupilHydrator(new PupilEntity())
            );
        });

        $this->app->bind(BoardingHouseRepositoryContract::class, function () {
            return new EloquentBoardingHouseRepository(
                new BoardingHouse(),
                new EloquentBoardingHouseHydrator(app(BoardingHouseEntity::class))
            );
        });
    }
}
