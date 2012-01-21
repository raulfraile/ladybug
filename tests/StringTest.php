<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Autoloader::register();

class StringTest extends PHPUnit_Framework_TestCase
{
    public function testStringGetsSameValueAndRightLength() {
        $vars = array(
            '',
            'test',
            'áéíóú',
            'ÁÉÍÓÚ',
            '12345'
        );
        
        $lengths = array(0, 4, 5, 5, 5);
        
        $result = ladybug_dump_return('php', $vars[0], $vars[1], $vars[2], $vars[3], $vars[4]);

        $this->assertEquals(count($result), count($vars));
        
        $i = 0;
        foreach ($result as $item) {
            $this->assertEquals('string', $item['type']);
            $this->assertEquals($vars[$i], $item['value']);
            $this->assertEquals($lengths[$i], $item['length']);
            
            $i++;
        }
    }    
}
