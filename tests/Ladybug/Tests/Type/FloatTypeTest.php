<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class FloatTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var Type\Float $type */
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
        $this->assertEquals(1, $this->type->getLevel());
        $this->assertEquals(3, $this->type->getDecimals());
        $this->assertFalse($this->type->isNan());
        $this->assertFalse($this->type->isInfinite());
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

    public function testNanValue()
    {
        $var = acos(1.01);

        $this->type->load($var);
        $this->assertTrue($this->type->isNan());
    }

    public function testInfiniteValue()
    {
        $var = log(0);

        $this->type->load($var);
        $this->assertTrue($this->type->isInfinite());
    }

    public function testPiMathConstantDetection()
    {
        $var = pi();

        $this->type->load($var);
        $this->assertEquals('pi', $this->type->getMathConstant());
    }

}
