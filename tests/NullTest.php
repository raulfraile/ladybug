<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();

class NullTest extends PHPUnit_Framework_TestCase
{
    public function testNullVariableGetsNull() {
        $var = NULL;
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var)), 'null');
    }
}

