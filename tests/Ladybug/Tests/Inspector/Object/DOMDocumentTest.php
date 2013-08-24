<?php

namespace Ladybug\Tests\Inspector\Object;

use Ladybug\Inspector;
use Ladybug\Type;
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Inspector\InspectorInterface;
use \Mockery as m;

class DOMDocumentTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\DOMDocument */
    protected $inspector;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());

        $extendedTypeFactoryMock = m::mock('Ladybug\Type\Extended\ExtendedTypeFactory');
        $extendedTypeFactoryMock->shouldReceive('factory')->with('code', m::any())->andReturn(new Type\Extended\CodeType());

        $this->inspector = new Inspector\Object\DOMDocument($factoryTypeMock, $extendedTypeFactoryMock);
    }

    public function testForValidValues()
    {
        $var = new \DOMDocument();

        $data = new InspectorDataWrapper();
        $data->setData($var);
        $data->setId(get_class($var));
        $data->setType(InspectorInterface::TYPE_CLASS);

        $result = $this->inspector->getData($data);

        $this->assertInstanceOf('Ladybug\Type\Extended\CodeType', $result);
        $this->assertEquals('xml', $result->getLanguage());
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
