<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class FloatTypeTest extends \PHPUnit_Framework_TestCase
{

    public function testLoaderIsCorrect()
    {
        $var = 1.234;
        $key = 'key';

        $type = new Type\FloatType();

        // null key
        $type->load($var);
        $this->assertEquals($var, $type->getValue());
        $this->assertNull($type->getKey());

        // not null key
        $type->load($var, $key);
        $this->assertEquals($var, $type->getValue());
        $this->assertEquals($key, $type->getKey());
    }

    public function testInvalidValue()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $type = new Type\FloatType();
        $type->load($var);
    }

    public function testScientificNotationLoad()
    {
        $var = 1.2e3;

        $tyoe = new Type\FloatType();
        $tyoe->load($var);
        $this->assertEquals($tyoe->getFormattedValue(), $var);
    }

}
