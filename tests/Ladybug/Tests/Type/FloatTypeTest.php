<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class FloatTypeTest extends \PHPUnit_Framework_TestCase
{

    protected $type;

    public function setUp()
    {
        $this->type = new Type\FloatType();
    }

    public function testLoaderForValidValues()
    {
        $var = 1.234;

        $this->type->load($var);
        $this->assertEquals($var, $this->type->getValue());
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}
