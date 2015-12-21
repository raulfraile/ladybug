<?php

namespace Ladybug\Tests\Type\Vector;

use Ladybug\Type;
use \Mockery as m;

class ArrayTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var Type\Vector\Container */
    protected $type;

    public function setUp()
    {
        $maxlevel = 8;

        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturnUsing(function($var, $level) {
            $intType = new Type\IntType();
            $intType->load($var, $level);

            return $intType;
        });

        $this->type = new Type\Vector\Container($maxlevel, $factoryTypeMock);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testLoaderForValidValues()
    {
        $var = array(1, 2, 3);

        $this->type->load($var, 1);
        $this->assertEquals(3, $this->type->getLength());

        $items = $this->type->getValue();
        $this->assertCount(3, $items);
        $this->assertEquals(1, $this->type->getLevel());

        $i = 0;
        foreach ($this->type->getValue() as $item) {
            $this->assertEquals($i, $item->getKey());
            $this->assertEquals(2, $item->getLevel());
            $this->assertInstanceOf('Ladybug\Type\IntType', $item->getValue());

            $i++;
        }
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}
