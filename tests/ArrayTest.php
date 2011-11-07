<?php

require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();

class ArrayTest extends PHPUnit_Framework_TestCase
{
    protected $fruits;
    protected $countries;
 
    protected function setUp()
    {
        $this->fruits = array(
            'apple',
            'pear',
            'banana',
            'orange',
            'lemon'
        );
        
        $this->countries = array(
            'europe' => array(
                'spain',
                'uk',
                'italy',
                'germany'
            ),
            'america' => array(
                'usa',
                'canada',
                'mexico'
            )
        );
    }
    
    public function testEmptyArrayGetsEmpty() {
        $var = array();
        
        $this->assertEquals(strip_tags(ladybug_dump_return($var)), 'array []');
    }
    
    public function testSimpleArrayGetsAllElements() {
        $array_count = count($this->fruits);
        $result_lines = count(explode("\n",ladybug_dump_return($this->fruits)));
        
        $this->assertEquals($array_count + 2, $result_lines);
    }
    
    public function testNestedArrayGetsAllElements() {
        $array_count_level_1 = count($this->countries);
        $array_count = count($this->countries, COUNT_RECURSIVE);
        $result_lines = count(explode("\n",ladybug_dump_return($this->countries)));
        $expected = (($array_count - ($array_count - $array_count_level_1)) * 2) + $array_count;
        
        $this->assertEquals($expected, $result_lines);
    }
    
}

