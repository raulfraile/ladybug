<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;
use \Mockery as m;

class ArrayTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var Type\ArrayType */
    protected $type;

    public function setUp()
    {
        $maxlevel = 8;

        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());

        $this->type = new Type\ArrayType($maxlevel, $factoryTypeMock);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testLoaderForValidValues()
    {
        $var = array(1, 2, 3);

        $this->type->load($var);
        $this->assertEquals(3, $this->type->getLength());

        $items = $this->type->getValue();
        $this->assertCount(3, $items);
        $this->assertEquals(0, $items[0]->getKey());
        $this->assertInstanceOf('Ladybug\Type\IntType', $items[0]->getValue());
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}
