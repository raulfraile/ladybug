<?php

require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

class ArrayTest extends PHPUnit_Framework_TestCase
{

    public function testEmptyArrayGetsEmpty()
    {
        $vars = array(
            array(),
            (array) null
        );

        $result = ladybug_dump_return('php', $vars[0], $vars[1]);

        $this->assertEquals(count($vars), count($result));

        $i = 0;
        foreach ($result as $item) {
            $this->assertEquals('array', $item['type']);
            $this->assertEquals($vars[$i], $item['value']);
            $this->assertEquals(0, $item['length']);
            $i++;
        }
    }

    public function testSimpleArrayGetsAllElements()
    {
        $vars = array(
            range(1, 10),
            array('a')
        );

        $lengths = array(10, 1);

        $result = ladybug_dump_return('php', $vars[0], $vars[1]);

        $this->assertEquals(count($vars), count($result));

        $i = 0;
        foreach ($result as $item) {
            $this->assertEquals('array', $item['type']);
            $this->assertEquals($lengths[$i], $item['length']);
            $i++;
        }
    }

    public function testNestedArrayGetsAllElements()
    {
        $vars = array(
            array(
                0 => array(1, 2, 3),
                1 => array(4, 5, 6)
            )
        );

        $lengths = array(2);

        $result = ladybug_dump_return('php', $vars[0]);

        $this->assertEquals(count($vars), count($result));

        $i = 0;
        foreach ($result as $item) {
            $this->assertEquals('array', $item['type']);
            $this->assertEquals($lengths[$i], $item['length']);
            $this->assertEquals(3, count($item['value'][0]));
            $this->assertEquals(3, count($item['value'][1]));
            $i++;
        }
    }

    public function testDeepArrayGetsTruncated()
    {
        $var = range(1, 5);
        $max_deep = 3;
        $deep = 20;

        for ($i=0;$i<$deep;$i++) {
            $var[0] = $var;
        }

        ladybug_set('array.max_nesting_level', $max_deep);

        $result = ladybug_dump_return('php', $var);

        $this->assertEquals($max_deep, count($result['var1']));
    }
}
