<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug_Autoloader::register();

class IntegerTest extends PHPUnit_Framework_TestCase
{
    public function testIntegerGetsSameValue() {
        $var1 = 10;
        $var2 = -10;
        $var3 = 0123; // octal number, decimal: 83
        $var4 = 0x1A; // octal number, decimal: 26
        $var5 = 0;
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var1)), "int 10");
        $this->assertEquals(strip_tags(ladybug_dump_return($var2)), "int -10");
        $this->assertEquals(strip_tags(ladybug_dump_return($var3)), "int 83");
        $this->assertEquals(strip_tags(ladybug_dump_return($var4)), "int 26");
        $this->assertEquals(strip_tags(ladybug_dump_return($var5)), "int 0");
    }
    
    
}

