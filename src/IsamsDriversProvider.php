<?php

namespace SimonBowen\IsamsDrivers;

use Illuminate\Support\ServiceProvider;

use SimonBowen\IsamsDrivers\Entities\Pupil as PupilEntity;
use SimonBowen\IsamsDrivers\Entities\Set as SetEntity;
use SimonBowen\IsamsDrivers\Entities\Staff as StaffEntity;
use SimonBowen\IsamsDrivers\Models\Pupil;
use SimonBowen\IsamsDrivers\Models\Set;
use SimonBowen\IsamsDrivers\Models\Staff;
use SimonBowen\IsamsDrivers\Repositories\Contracts\PupilRepository as PupilRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Contracts\StaffRepository as StaffRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\Contracts\SetRepository as SetRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator as XmlPupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\SetHydrator as XmlSetHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\StaffHydrator as XmlStaffHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\PupilRepository as XmlPupilRepository;
use SimonBowen\IsamsDrivers\Repositories\XML\SetRepository as XmlSetRepository;
use SimonBowen\IsamsDrivers\Repositories\XML\StaffRepository as XmlStaffRepository;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\PupilRepository as EloquentPupilRepository;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\SetRepository as EloquentSetRepository;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\StaffRepository as EloquentStaffRepository;
use SimonBowen\IsamsDrivers\XML\Loader;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\PupilHydrator as EloquentPupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\StaffHydrator as EloquentStaffHydrator;
use SimonBowen\IsamsDrivers\Repositories\Eloquent\Hydrators\SetHydrator as EloquentSetHydrator;

class IsamsDriversProvider extends ServiceProvider {

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/isams.php' => config_path('isams.php'),
        ]);
    }

    public function register()
    {
        $driver = app('config')->get('isams.driver');
        if ($driver == 'xml') {
            $this->registerXml();
        } else if ($driver == 'db') {
            $this->registerDb();
        }
    }

    public function registerXml()
    {
        $this->app->bind(PupilRepositoryContract::class, function () {
            return new XmlPupilRepository(
                new Loader(),
                new XmlPupilHydrator(new PupilEntity())
            );
        });

        $this->app->bind(StaffRepositoryContract::class, function() {
            return new XmlStaffRepository(
                new Loader(),
                new XmlStaffHydrator(new StaffEntity()),
                new XmlSetHydrator(new SetEntity())
            );
        });

        $this->app->bind(SetRepositoryContract::class, function() {
            return new XmlSetRepository(
                new Loader(),
                new XmlSetHydrator(new SetEntity()),
                new XmlStaffHydrator(new StaffEntity()),
                new XmlPupilHydrator(new PupilEntity())
            );
        });

    }

    public function registerDb()
    {
        $this->app->bind(PupilRepositoryContract::class, function() {
            return new EloquentPupilRepository(
                new Pupil(),
                new EloquentPupilHydrator(new PupilEntity())
            );
        });

        $this->app->bind(StaffRepositoryContract::class, function() {
            return new EloquentStaffRepository(
                new Staff(),
                new EloquentStaffHydrator(new StaffEntity())
            );
        });

        $this->app->bind(SetRepositoryContract::class, function() {
            return new EloquentSetRepository(
                new Set(),
                new EloquentSetHydrator(new SetEntity()),
                new EloquentStaffHydrator(new StaffEntity()),
                new EloquentPupilHydrator(new PupilEntity())
            );
        });
    }

}