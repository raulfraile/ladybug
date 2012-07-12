<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

class ResourceTest extends PHPUnit_Framework_TestCase
{
    protected $file;
    protected $image;

    protected function setUp()
    {
        $this->file = fopen(__DIR__.'/files/test.txt', 'r');
        $this->image = imagecreatefrompng(__DIR__ . '/files/ladybug.png');
        $this->result = ladybug_dump_return('php', $this->file, $this->image);
    }

    public function testResourceGetsRightType()
    {
        $this->assertEquals('resource(file)', $this->result['var1']['type']);
        $this->assertEquals('resource(gd)', $this->result['var2']['type']);
    }

}
