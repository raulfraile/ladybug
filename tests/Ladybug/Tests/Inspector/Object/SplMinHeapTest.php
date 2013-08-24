<?php

namespace Ladybug\Tests\Inspector\Object;

use Ladybug\Inspector;
use Ladybug\Type;
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Inspector\InspectorInterface;
use \Mockery as m;

class SplMinHeapTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\SplMinHeap */
    protected $inspector;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());

        $extendedTypeFactoryMock = m::mock('Ladybug\Type\Extended\ExtendedTypeFactory');
        $extendedTypeFactoryMock->shouldReceive('factory')->with('collection', m::any())->andReturn(new Type\Extended\CollectionType());

        $this->inspector = new Inspector\Object\SplMinHeap($factoryTypeMock, $extendedTypeFactoryMock);
    }

    public function testForValidValues()
    {
        $var = new \SplMinHeap();
        $var->insert(1);
        $var->insert(2);
        $var->insert(3);

        $data = new InspectorDataWrapper();
        $data->setData($var);
        $data->setId(get_class($var));
        $data->setType(InspectorInterface::TYPE_CLASS);

        $result = $this->inspector->getData($data);

        $this->assertInstanceOf('Ladybug\Type\Extended\CollectionType', $result);
        $this->assertCount(3, $result);
    }

    public function testForInvalidValues()
    {
        $this->setExpectedException('Ladybug\Exception\InvalidInspectorClassException');

        $var = new \stdClass();

        $data = new InspectorDataWrapper();
        $data->setData($var);
        $data->setId(get_class($var));
        $data->setType(InspectorInterface::TYPE_CLASS);

        $this->inspector->getData($data);
    }

}
