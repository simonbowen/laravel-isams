<?php
require 'vendor/autoload.php';

abstract class BaseTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }
}
