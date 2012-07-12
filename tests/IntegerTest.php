<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

class IntegerTest extends PHPUnit_Framework_TestCase
{
    public function testIntegerGetsSameValue()
    {
        $vars = array(
            10,
            -10,
            0123, // octal number, decimal: 83
            0x1A, // octal number, decimal: 26
            0
        );

        $result = ladybug_dump_return('php', $vars[0], $vars[1], $vars[2], $vars[3], $vars[4]);

        $this->assertEquals(count($result), 5);

        $i = 0;
        foreach ($result as $item) {
            $this->assertEquals('int', $item['type']);
            $this->assertEquals($vars[$i], $item['value']);
            $i++;
        }
    }
}
