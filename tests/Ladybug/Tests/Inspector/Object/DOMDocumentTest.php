<?php

namespace Ladybug\Tests\Inspector\Object;

use Ladybug\Inspector;
use Ladybug\Type;
use \Mockery as m;

class DOMDocumentTest extends \PHPUnit_Framework_TestCase
{

    /** @var Inspector\Object\DOMDocument */
    protected $inspector;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\IntType());

        $this->inspector = new Inspector\Object\DOMDocument($factoryTypeMock);
    }

    public function testForValidValues()
    {
        $var = new \DOMDocument();

        $result = $this->inspector->getData($var);

        $this->assertInstanceOf('Ladybug\Type\Extended\CodeType', $result);
        $this->assertEquals('xml', $result->getLanguage());
    }

    public function testForInvalidValues()
    {
        $this->setExpectedException('Ladybug\Exception\InvalidInspectorClassException');

        $var = new \stdClass();

        $this->inspector->getData($var);
    }

}
