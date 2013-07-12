<?php

namespace Ladybug\Tests\Inspector\Object;

use Ladybug\Inspector;
use Ladybug\Type;
use \Mockery as m;

class SplStackTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\SplStack */
    protected $inspector;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());

        $this->inspector = new Inspector\Object\SplStack($factoryTypeMock);
    }

    public function testForValidValues()
    {
        $var = new \SplStack();
        $var->push(1);
        $var->push(2);
        $var->push(3);

        $result = $this->inspector->getData($var);

        $this->assertInstanceOf('Ladybug\Type\Extended\CollectionType', $result);
        $this->assertCount(3, $result);
    }

    public function testForInvalidValues()
    {
        $this->setExpectedException('Ladybug\Exception\InvalidInspectorClassException');

        $var = new \stdClass();

        $this->inspector->getData($var);
    }

}
