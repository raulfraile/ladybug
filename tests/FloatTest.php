<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

class FloatTest extends PHPUnit_Framework_TestCase
{
    public function testFloatGetsSameValue()
    {
        $vars = array(1.234, 1.2e3, 7E-10);

        $result = ladybug_dump_return('php', $vars[0], $vars[1], $vars[2]);

        $this->assertEquals(count($result), 3);

        $i = 0;
        foreach ($result as $item) {
            $this->assertEquals('float', $item['type']);
            $this->assertEquals($vars[$i], $item['value']);
            $i++;
        }
    }
}
