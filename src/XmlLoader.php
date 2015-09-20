<?php

namespace SimonBowen\IsamsDrivers;

class XmlLoader {

    protected $xml;

    public function __construct($url)
    {
        $this->load($url);
    }

    public function load($url)
    {
        if ( ! $this->xml) {
            $this->xml = simplexml_load_file($url);
        }
        return $this->xml;
    }

    public function getXml()
    {
        return $this->xml;
    }

}