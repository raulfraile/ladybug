<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

class BoolTest extends PHPUnit_Framework_TestCase
{
    public function testTrueValuesGetsTrue()
    {
        $var1 = true;
        $var2 = (bool) 1;
        $var3 = (bool) -2;
        $var4 = (bool) "foo";
        $var5 = (bool) 2.3e5;

        $result = ladybug_dump_return('php', $var1, $var2, $var3, $var4, $var5);

        $this->assertEquals(count($result), 5);

        foreach ($result as $item) {
            $this->assertEquals('bool', $item['type']);
            $this->assertEquals(true, $item['value']);
        }
    }

    public function testFalseValuesGetsFalse()
    {
        $var1 = false;
        $var2 = (bool) 0;
        $var3 = (bool) 0.0;
        $var4 = (bool) "";
        $var5 = (bool) "0";
        $var6 = (bool) array();

        $result = ladybug_dump_return('php', $var1, $var2, $var3, $var4, $var5, $var6);

        $this->assertEquals(count($result), 6);

        foreach ($result as $item) {
            $this->assertEquals('bool', $item['type']);
            $this->assertEquals(false, $item['value']);
        }
    }

}

