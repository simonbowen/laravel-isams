<?php namespace SimonBowen\IsamsDrivers\XML;

class Manager {

    protected $domXpath;

    public function __construct($xml)
    {
        $dom = new \DOMDocument();
        $dom->loadXml($xml);

        $this->domXpath = new \DOMXPath($dom);
        $this->domXpath->registerNamespace("php", "http://php.net/xpath");
        $this->domXpath->registerPhpFunctions('strtolower');
    }

    public function xpath($path)
    {
        return iterator_to_array($this->domXpath->query($path));
    }

}