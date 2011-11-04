<?php
ini_set('xdebug.max_nesting_level',2000);
require_once 'PHPUnit/Framework/TestCase.php';
require_once __DIR__.'/../lib/Ladybug.php';

class ResourceTest extends PHPUnit_Framework_TestCase
{
    protected $file;
 
    protected function setUp()
    {
        $this->file = fopen(__DIR__.'/files/test.txt', 'r');
    }
    
    public function testEmptyObjectGetsEmpty() {
        $this->assertTrue(strpos(strip_tags(ladybug_dump_return($this->file)), 'resource(file) [') !== FALSE);
    }
    
    
}

