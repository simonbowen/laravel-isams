<?php

namespace SimonBowen\IsamsDrivers\Repositories\XML;

abstract class BaseRepository {

    protected $xml;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

}