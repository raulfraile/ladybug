<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class NullTypeTest extends \PHPUnit_Framework_TestCase
{

    public function testLoaderIsCorrect()
    {
        $var = null;
        $key = 'key';

        $type = new Type\NullType();

        // null key
        $type->load($var);
        $this->assertNull($type->getValue());
        $this->assertNull($type->getKey());

        // not null key
        $type->load($var, $key);
        $this->assertNull($var);
        $this->assertSame($key, $type->getKey());
    }

    public function testInvalidValue()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $type = new Type\NullType();
        $type->load($var);
    }

}
