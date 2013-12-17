<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;
use Ladybug\Type\ObjectType\VisibilityInterface;
use \Mockery as m;

class ResourceTest extends \PHPUnit_Framework_TestCase
{

    /** @var Type\Resource $type */
    protected $type;

    public function setUp()
    {
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3), m::any())->andReturn(new Type\Int());

        $managerInspectorMock = m::mock('Ladybug\Inspector\InspectorManager');
        $managerInspectorMock->shouldReceive('get')->andReturn(null);

        $metadataResolverMock = m::mock('Ladybug\Metadata\MetadataResolver');
        $metadataResolverMock->shouldReceive('has')->andReturn(false);

        $this->type = new Type\Resource($factoryTypeMock, $managerInspectorMock, $metadataResolverMock);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testLoaderForValidValues()
    {
        $var = fopen(__DIR__ . '/../../../files/test.txt', 'rb');

        $this->type->load($var);

        $this->assertEquals('file', $this->type->getResourceType());
        $this->assertEquals(1, $this->type->getLevel());
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}
