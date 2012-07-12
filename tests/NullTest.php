<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

class NullTest extends PHPUnit_Framework_TestCase
{
    public function testNullVariableGetsNull()
    {
        $vars = array(
            null
        );

        $result = ladybug_dump_return('php', $vars[0]);

        $this->assertEquals(count($result), 1);

        $i = 0;
        foreach ($result as $item) {
            $this->assertEquals('null', $item['type']);
            $this->assertEquals(null, $item['value']);
            $i++;
        }
    }
}
