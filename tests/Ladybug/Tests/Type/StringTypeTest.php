<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class StringTypeTest extends \PHPUnit_Framework_TestCase
{

    public function testLoaderIsCorrect()
    {
        $var = 'value';
        $key = 'key';

        $type = new Type\StringType();

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

        $var = 1;

        $type = new Type\StringType();
        $type->load($var);
    }

    public function testUtf8Length()
    {
        $var = 'Россия';

        $type = new Type\StringType();

        $type->load($var);
        $this->assertEquals(6, $type->getLength());
    }

}
