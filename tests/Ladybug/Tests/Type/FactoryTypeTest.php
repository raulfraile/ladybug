<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;
use \Mockery as m;

class FactoryTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @var Type\FactoryType $factory */
    protected $factory;

    public function setUp()
    {
        /*$maxlevel = 8;

        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());
*/
        $this->factory = new Type\FactoryType();
        $this->factory->add(new Type\IntType(), 'type_int');
        $this->factory->add(new Type\BoolType(), 'type_bool');
        $this->factory->add(new Type\NullType(), 'type_null');
        $this->factory->add(new Type\FloatType(), 'type_float');
        $this->factory->add(new Type\StringType(), 'type_string');
        $this->factory->add(new Type\ArrayType(8, $this->factory), 'type_array');
    }

    public function tearDown()
    {
        m::close();
    }

    public function testFactoryForIntValues()
    {
        $var = 1;
        $type = $this->factory->factory($var);
        $this->assertEquals('Ladybug\\Type\\IntType', get_class($type));
    }

    public function testFactoryForBoolValues()
    {
        $var = true;
        $type = $this->factory->factory($var);
        $this->assertEquals('Ladybug\\Type\\BoolType', get_class($type));
    }

    public function testFactoryForFloatValues()
    {
        $var = 1.2;
        $type = $this->factory->factory($var);
        $this->assertEquals('Ladybug\\Type\\FloatType', get_class($type));
    }

    public function testFactoryForNullValues()
    {
        $var = null;
        $type = $this->factory->factory($var);
        $this->assertEquals('Ladybug\\Type\\NullType', get_class($type));
    }

    public function testFactoryForStringValues()
    {
        $var = 'test';
        $type = $this->factory->factory($var);
        $this->assertEquals('Ladybug\\Type\\StringType', get_class($type));
    }

    public function testFactoryForArrayValues()
    {
        $var = array(1, 2, 3);
        $type = $this->factory->factory($var);
        $this->assertEquals('Ladybug\\Type\\ArrayType', get_class($type));
    }

    /*public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->factory->load($var);
    }*/

}
