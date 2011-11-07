<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();

class FloatTest extends PHPUnit_Framework_TestCase
{
    public function testFloatGetsSameValue() {
        $var1 = 1.234;
        $var2 = 1.2e3;
        $var3 = 7E-10;
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var1)), "float $var1");
        $this->assertEquals(strip_tags(ladybug_dump_return($var2)), "float $var2");
        $this->assertEquals(strip_tags(ladybug_dump_return($var3)), "float $var3");
    }
    
    
}

