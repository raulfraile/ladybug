<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class BoolTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var Type\Bool $type */
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
        $this->assertEquals('true', $this->type->getFormattedValue());
        $this->assertEquals(1, $this->type->getLevel());

        // false
        $var = false;
        $this->type->load($var);
        $this->assertFalse($this->type->getValue());
        $this->assertEquals('false', $this->type->getFormattedValue());
        $this->assertEquals(1, $this->type->getLevel());
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}
