<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug_Autoloader::register();

class StringTest extends PHPUnit_Framework_TestCase
{
    public function testStringGetsSameValueAndRightLength() {
        $var = 'test';
        $length = strlen($var);
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var)), "string($length) \"$var\"");
    }
    
    public function testEmptyStringGetsEmptyValueAndZeroLength() {
        $var = '';
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var)), "string(0) \"\"");
    }
}

