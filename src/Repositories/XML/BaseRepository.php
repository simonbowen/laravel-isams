<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

use SimonBowen\IsamsDrivers\XML\Loader;

abstract class BaseRepository
{
    protected $xml;

    public function __construct(Loader $loader)
    {
        $this->xml = $loader->get();
    }
}
