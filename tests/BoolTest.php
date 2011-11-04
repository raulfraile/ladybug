<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once __DIR__.'/../lib/Ladybug.php';

class BoolTest extends PHPUnit_Framework_TestCase
{
    public function testTrueValuesGetsTRUE() {
        $var1 = true;
        $var2 = (bool) 1;
        $var3 = (bool) -2;
        $var4 = (bool) "foo";
        $var5 = (bool) 2.3e5;
        
        $expected = 'bool TRUE';
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var1)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var2)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var3)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var4)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var5)), $expected);
    }
    
    public function testFalseValuesGetsFALSE() {
        $var1 = false;
        $var2 = (bool) 0;
        $var3 = (bool) 0.0;
        $var4 = (bool) "";
        $var5 = (bool) "0";
        $var6 = (bool) array();
        
        $expected = 'bool FALSE';
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var1)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var2)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var3)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var4)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var5)), $expected);
        $this->assertEquals(strip_tags(ladybug_dump_return($var6)), $expected);
    }
    
}

