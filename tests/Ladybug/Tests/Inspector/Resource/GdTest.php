<?php

namespace Ladybug\Tests\Inspector\Resource;

use Ladybug\Inspector;
use Ladybug\Type;
use \Mockery as m;

class GdTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\SplMinHeap */
    protected $inspector;

    public function setUp()
    {
        if (!extension_loaded('gd')) {
            $this->markTestSkipped(
                'The GD extension is not available.'
            );
        }

        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::any(), m::any())->andReturn(new Type\IntType());

        $extendedTypeFactoryMock = m::mock('Ladybug\Type\Extended\ExtendedTypeFactory');
        $extendedTypeFactoryMock->shouldReceive('factory')->with('collection', m::any())->andReturnUsing(function() {return new Type\Extended\CollectionType();});
        $extendedTypeFactoryMock->shouldReceive('factory')->with('text', m::any())->andReturn(new Type\Extended\TextType());
        $extendedTypeFactoryMock->shouldReceive('factory')->with('image', m::any())->andReturn(new Type\Extended\ImageType());

        $this->inspector = new Inspector\Resource\Gd($factoryTypeMock, $extendedTypeFactoryMock);
    }

    public function testForValidValues()
    {
        $var = imagecreatefrompng(__DIR__ . '/../../../../files/ladybug.png');

        $result = $this->inspector->getData($var);

        $this->assertInstanceOf('Ladybug\Type\Extended\ExtendedTypeInterface', $result);
    }

    public function testForInvalidValues()
    {
        $this->setExpectedException('Ladybug\Exception\InvalidInspectorClassException');

        $var = new \stdClass();

        $this->inspector->getData($var);
    }

}
