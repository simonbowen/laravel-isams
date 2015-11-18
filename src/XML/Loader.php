<?php

namespace SimonBowen\IsamsDrivers\XML;

use Config;
use Cache;

class Loader {

    public function get()
    {
        $cacheTime = Config::get('isams.xml.cache', 60);
        $xml = Cache::remember('isams.xml', $cacheTime, function() {
            $url = Config::get('isams.xml.url');
            return file_get_contents($url);
        });

        return new Manager($xml);
    }

}