<?php

namespace Ladybug\Tests\Inspector\Resource;

use Ladybug\Inspector;
use Ladybug\Type;
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

        $this->inspector = new Inspector\Resource\File($factoryTypeMock, $extendedTypeFactoryMock);
    }

    public function testForValidValues()
    {
        $var = fopen(__DIR__ . '/../../../../files/test.txt', 'rb');

        $result = $this->inspector->getData($var);

        $this->assertInstanceOf('Ladybug\Type\Extended\CollectionType', $result);
    }

    public function testForInvalidValues()
    {
        $this->setExpectedException('Ladybug\Exception\InvalidInspectorClassException');

        $var = new \stdClass();

        $this->inspector->getData($var);
    }

}
