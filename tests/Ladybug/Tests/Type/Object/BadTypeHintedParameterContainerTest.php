<?php

namespace Ladybug\Tests\Type\Object;

use Ladybug\Inspector\InspectorManager;
use Ladybug\Metadata\MetadataResolver;
use Ladybug\Type;

use \Mockery as m;

class BadTypeHintedParameterContainerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Type\Object $type */
    protected $type;

    protected function setUp()
    {
        $factory = new Type\FactoryType();
        $factory->add(new Type\NullType(), 'type_null');

        $managerInspectorMock = m::mock('Ladybug\Inspector\InspectorManager');
        $managerInspectorMock->shouldReceive('get')->andReturn(null);

        $metadataResolverMock = m::mock('Ladybug\Metadata\MetadataResolver');
        $metadataResolverMock->shouldReceive('has')->andReturn(false);

        $this->type = new Type\Object\Container(8, $factory, $managerInspectorMock, $metadataResolverMock);
    }

    protected function tearDown()
    {
        $this->type = null;
    }

    public function testDumperDoesNotCrashOnWrongTypeHints()
    {
        $var = new FlawedClass();
        $this->type->load($var);

        // class info
        $this->assertEquals('Ladybug\Tests\Type\Object\FlawedClass', $this->type->getClassName());
        $this->assertEquals(__FILE__, $this->type->getClassFile());

        $this->assertCount(2, $this->type->getClassMethods());

        $privateMethod = $this->type->getMethodByName('privateMethod');
        $this->assertCount(2, $privateMethod->getParameters());

        $parameter1 = $privateMethod->getParameterByName('bar');
        $this->assertNull($parameter1->getType());
        $this->assertFalse($parameter1->isReference());

        $badTypeHinted = $privateMethod->getParameterByName('baz');
        $this->assertEquals('[Undefined Type Hint]', $badTypeHinted->getType());
        $this->assertFalse($badTypeHinted->isReference());
        $this->assertInstanceOf('Ladybug\Type\NullType', $badTypeHinted->getDefaultValue());
    }
}

class FlawedClass
{
    public function publicMethod()
    {
        $foo = 'bar';
        $this->privateMethod($foo, null);
    }

    private function privateMethod($bar, UndefinedTypeHint $baz = null)
    {
    }
}
