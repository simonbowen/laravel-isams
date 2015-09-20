<?php

namespace SimonBowen\IsamsDrivers;

use Illuminate\Support\ServiceProvider;

use SimonBowen\IsamsDrivers\Repositories\Contracts\PupilRepository as PupilRepositoryContract;
use SimonBowen\IsamsDrivers\Repositories\XML\Hydrators\PupilHydrator;
use SimonBowen\IsamsDrivers\Repositories\XML\PupilRepository;

class IsamsDriversProvider extends ServiceProvider {

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
        $this->app->singleton(XmlLoader::class, function() {
            $url = app('config')->get('isams.xml.url');
            return new XmlLoader($url);
        });

        $this->app->bind(PupilRepositoryContract::class, function () {
            $hydrator = new PupilHydrator();
            $xmlLoader = app(XmlLoader::class);
            return new PupilRepository($xmlLoader->getXml(), $hydrator);
        });
    }

}