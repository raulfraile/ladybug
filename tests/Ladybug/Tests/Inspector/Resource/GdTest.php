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

        $this->inspector = new Inspector\Resource\Gd($factoryTypeMock);
    }

    public function testForValidValues()
    {
        $var = imagecreatefrompng(__DIR__ . '/../../../../files/ladybug.png');

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
