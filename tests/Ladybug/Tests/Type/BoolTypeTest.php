<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class BoolTypeTest extends \PHPUnit_Framework_TestCase
{

    public function testLoaderIsCorrect()
    {
        $var = true;
        $key = 'key';

        $type = new Type\BoolType();

        // null key
        $type->load($var);
        $this->assertSame($var, $type->getValue());
        $this->assertNull($type->getKey());

        // not null key
        $type->load($var, $key);
        $this->assertSame($var, $type->getValue());
        $this->assertSame($key, $type->getKey());
    }

    public function testInvalidValue()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $type = new Type\BoolType();
        $type->load($var);
    }

}
