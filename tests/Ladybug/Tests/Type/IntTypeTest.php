<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class IntTypeTest extends \PHPUnit_Framework_TestCase
{

    public function testLoaderIsCorrect()
    {
        $var = 1;
        $key = 'key';

        $type = new Type\IntType();

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

        $type = new Type\IntType();
        $type->load($var);
    }

}
