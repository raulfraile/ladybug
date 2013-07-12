<?php

namespace Ladybug\Tests\Inspector\Object;

use Ladybug\Inspector;
use Ladybug\Type;
use \Mockery as m;

class SplMaxHeapTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\SplMaxHeap */
    protected $inspector;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());

        $this->inspector = new Inspector\Object\SplMaxHeap($factoryTypeMock);
    }

    public function testForValidValues()
    {
        $var = new \SplMaxHeap();
        $var->insert(1);
        $var->insert(2);
        $var->insert(3);

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
