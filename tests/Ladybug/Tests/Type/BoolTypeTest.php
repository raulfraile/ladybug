<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class BoolTypeTest extends \PHPUnit_Framework_TestCase
{

    protected $type;

    public function setUp()
    {
        $this->type = new Type\BoolType();
    }

    public function testLoaderForValidValues()
    {
        // true
        $var = true;
        $this->type->load($var);
        $this->assertTrue($this->type->getValue());

        // false
        $var = false;
        $this->type->load($var);
        $this->assertFalse($this->type->getValue());
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}
