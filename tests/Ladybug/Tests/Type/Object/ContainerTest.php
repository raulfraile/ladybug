<?php

namespace Ladybug\Tests\Type\Object;

use Ladybug\Type;
use Ladybug\Type\Object\VisibilityInterface;
use \Mockery as m;

class ContainerTest extends \PHPUnit_Framework_TestCase
{

    /** @var Type\Object $type */
    protected $type;

    public function setUp()
    {
        $maxlevel = 8;
        $factoryTypeMock = m::mock('Ladybug\Type\FactoryType');
        $factoryTypeMock->shouldReceive('factory')->with(m::anyOf(1, 2, 3, 4), m::any())->andReturnUsing(function($var, $level) {
            $intType = new Type\IntType();
            $intType->load($var, $level);

            return $intType;
        });

        $managerInspectorMock = m::mock('Ladybug\Inspector\InspectorManager');
        $managerInspectorMock->shouldReceive('get')->andReturn(null);

        $metadataResolverMock = m::mock('Ladybug\Metadata\MetadataResolver');
        $metadataResolverMock->shouldReceive('has')->andReturn(false);

        $this->type = new Type\Object\Container($maxlevel, $factoryTypeMock, $managerInspectorMock, $metadataResolverMock);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testLoaderForValidValues()
    {
        $var = new Bar();

        $this->type->load($var);

        $this->assertEquals(1, $this->type->getLevel());

        // class info
        $this->assertEquals('Ladybug\Tests\Type\Object\Bar', $this->type->getClassName());
        $this->assertEquals(__FILE__, $this->type->getClassFile());
        $this->assertEquals('Serializable', $this->type->getClassInterfaces());
        $this->assertEquals('Ladybug\Tests\Type\Object', $this->type->getClassNamespace());
        $this->assertEquals('Ladybug\Tests\Type\Object\Foo', $this->type->getClassParent());

        // properties
        $this->assertEquals(3, count($this->type->getObjectProperties()));
        $privateProperty = $this->type->getObjectProperty('privateProperty', VisibilityInterface::VISIBILITY_PRIVATE);
        $protectedProperty = $this->type->getObjectProperty('protectedProperty', VisibilityInterface::VISIBILITY_PROTECTED);
        $publicProperty = $this->type->getObjectProperty('publicProperty', VisibilityInterface::VISIBILITY_PUBLIC);

        $this->assertInstanceOf('Ladybug\Type\Object\Property', $privateProperty);
        $this->assertEquals('privateProperty', $privateProperty->getName());
        $this->assertEquals(VisibilityInterface::VISIBILITY_PRIVATE, $privateProperty->getVisibility());
        $this->assertInstanceOf('Ladybug\Type\IntType', $privateProperty->getValue());
        $this->assertEquals(2, $privateProperty->getLevel());
        $this->assertEquals('Ladybug\Tests\Type\Object\Bar', $privateProperty->getOwner());

        $this->assertInstanceOf('Ladybug\Type\Object\Property', $protectedProperty);
        $this->assertEquals('protectedProperty', $protectedProperty->getName());
        $this->assertEquals(VisibilityInterface::VISIBILITY_PROTECTED, $protectedProperty->getVisibility());
        $this->assertInstanceOf('Ladybug\Type\IntType', $protectedProperty->getValue());
        $this->assertEquals(2, $protectedProperty->getLevel());
        $this->assertEquals('Ladybug\Tests\Type\Object\Bar', $protectedProperty->getOwner());

        $this->assertInstanceOf('Ladybug\Type\Object\Property', $publicProperty);
        $this->assertEquals('publicProperty', $publicProperty->getName());
        $this->assertEquals(VisibilityInterface::VISIBILITY_PUBLIC, $publicProperty->getVisibility());
        $this->assertInstanceOf('Ladybug\Type\IntType', $publicProperty->getValue());
        $this->assertEquals(2, $publicProperty->getLevel());
        $this->assertEquals('Ladybug\Tests\Type\Object\Bar', $publicProperty->getOwner());

        // constants
        $this->assertEquals(1, count($this->type->getClassConstants()));
        $constant = $this->type->getConstantByName('CONSTANT');
        $this->assertEquals('CONSTANT', $constant->getName());
        $this->assertInstanceOf('Ladybug\Type\IntType', $constant->getValue());
        $this->assertEquals(2, $constant->getLevel());

        // methods
        $this->assertEquals(6, count($this->type->getClassMethods()));

        $constructMethod = $this->type->getMethodByName('__construct');
        $protectedMethod = $this->type->getMethodByName('protectedMethod');
        $privateMethod = $this->type->getMethodByName('privateMethod');
        $staticMethod = $this->type->getMethodByName('staticMethod');

        $this->assertEquals('__construct', $constructMethod->getName());
        $this->assertEquals(VisibilityInterface::VISIBILITY_PUBLIC, $constructMethod->getVisibility());
        $this->assertFalse($constructMethod->isStatic());
        $this->assertEquals('protectedMethod', $protectedMethod->getName());
        $this->assertEquals(VisibilityInterface::VISIBILITY_PROTECTED, $protectedMethod->getVisibility());
        $this->assertFalse($protectedMethod->isStatic());
        $this->assertEquals('privateMethod', $privateMethod->getName());
        $this->assertEquals(VisibilityInterface::VISIBILITY_PRIVATE, $privateMethod->getVisibility());
        $this->assertFalse($privateMethod->isStatic());
        $this->assertEquals('staticMethod', $staticMethod->getName());
        $this->assertEquals(VisibilityInterface::VISIBILITY_PUBLIC, $staticMethod->getVisibility());
        $this->assertTrue($staticMethod->isStatic());

        // method parameters
        $this->assertCount(5, $privateMethod->getParameters());

        $parameter1 = $privateMethod->getParameterByName('p1');
        $parameter2 = $privateMethod->getParameterByName('p2');
        $parameter3 = $privateMethod->getParameterByName('p3');
        $parameter4 = $privateMethod->getParameterByName('p4');
        $parameter5 = $privateMethod->getParameterByName('p5');

        $this->assertEquals('p1', $parameter1->getName());
        $this->assertFalse($parameter1->isReference());
        $this->assertNull($parameter1->getDefaultValue());
        $this->assertNull($parameter1->getType());

        $this->assertEquals('p2', $parameter2->getName());
        $this->assertTrue($parameter2->isReference());
        $this->assertNull($parameter2->getDefaultValue());
        $this->assertNull($parameter2->getType());

        $this->assertEquals('p3', $parameter3->getName());
        $this->assertFalse($parameter3->isReference());
        $this->assertNull($parameter3->getDefaultValue());
        $this->assertEquals('array', $parameter3->getType());

        $this->assertEquals('p4', $parameter4->getName());
        $this->assertFalse($parameter4->isReference());
        $this->assertNull($parameter4->getDefaultValue());
        $this->assertEquals('DateTime', $parameter4->getType());

        $this->assertEquals('p5', $parameter5->getName());
        $this->assertFalse($parameter5->isReference());
        $this->assertInstanceOf('Ladybug\Type\IntType', $parameter5->getDefaultValue());
        $this->assertNull($parameter5->getType());

        // method info
        if (class_exists('\phpDocumentor\Reflection\DocBlock')) {
            $this->assertEquals('Private method', $privateMethod->getShortDescription());
        }
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}

class Foo {
    private $privateParentProperty;

    public function __construct()
    {
        $this->privateParentProperty = 4;
    }
}

class Bar extends Foo implements \Serializable
{
    private $privateProperty;
    protected $protectedProperty;
    public $publicProperty;

    const CONSTANT = 1;

    public function __construct()
    {
        parent::__construct();
        $this->privateProperty = 1;
        $this->protectedProperty = 2;
        $this->publicProperty = 3;
    }


    public function serialize()
    {
        // TODO: Implement serialize() method.
    }


    public function unserialize($serialized)
    {

    }

    protected function protectedMethod()
    {

    }

    /**
     * Private method
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string test result
     */
    private function privateMethod($p1, &$p2, array $p3, \DateTime $p4, $p5 = 1)
    {

    }

    public static function staticMethod()
    {

    }


}