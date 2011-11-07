<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();

class Foo {}

class ObjectTest extends PHPUnit_Framework_TestCase
{
    protected $date;
    protected $foo;
 
    protected function setUp()
    {
        
        $this->date = new DateTime();
        $this->foo = new Foo();
    }
    
    public function testEmptyObjectGetsEmpty() {
        $this->assertEquals(strip_tags(ladybug_dump_return($this->foo)), 'object(Foo) []');
    }
    
    
}

