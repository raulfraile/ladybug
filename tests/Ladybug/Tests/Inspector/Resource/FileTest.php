<?php

namespace Ladybug\Tests\Inspector\Resource;

use Ladybug\Inspector;
use Ladybug\Type;
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Inspector\InspectorInterface;
use \Mockery as m;

class FileTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\SplMinHeap */
    protected $inspector;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::any(), m::any())->andReturn(new Type\IntType());

        $extendedTypeFactoryMock = m::mock('Ladybug\Type\Extended\ExtendedTypeFactory');
        $extendedTypeFactoryMock->shouldReceive('factory')->with('collection', m::any())->andReturn(new Type\Extended\CollectionType());
        $extendedTypeFactoryMock->shouldReceive('factory')->with('unixpermissions', m::any())->andReturn(new Type\Extended\UnixPermissionsType());
        $extendedTypeFactoryMock->shouldReceive('factory')->with('size', m::any())->andReturn(new Type\Extended\SizeType());
        $extendedTypeFactoryMock->shouldReceive('factory')->with('text', m::any())->andReturn(new Type\Extended\TextType());
        $extendedTypeFactoryMock->shouldReceive('factory')->with('code', m::any())->andReturn(new Type\Extended\CodeType());

        $this->inspector = new Inspector\Resource\File($factoryTypeMock, $extendedTypeFactoryMock);
    }

    public function testForValidValues()
    {
        $var = fopen(__DIR__ . '/../../../../files/test.txt', 'rb');

        $data = new InspectorDataWrapper();
        $data->setData($var);
        $data->setId('file');
        $data->setType(InspectorInterface::TYPE_RESOURCE);

        $result = $this->inspector->getData($data);

        $this->assertInstanceOf('Ladybug\Type\Extended\CollectionType', $result);
    }

    public function testForInvalidValues()
    {
        $this->setExpectedException('Ladybug\Exception\InvalidInspectorClassException');

        $var = new \stdClass();

        $data = new InspectorDataWrapper();
        $data->setData($var);
        $data->setId(get_class($var));
        $data->setType(InspectorInterface::TYPE_RESOURCE);

        $this->inspector->getData($data);
    }

}
