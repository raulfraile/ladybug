<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class ObjectTypeTest extends \PHPUnit_Framework_TestCase
{

    protected $var;

    public function setUp()
    {
        $this->var = new TestClass();
    }

    public function testLoaderIsCorrect()
    {
        $type = new Type\ObjectType(1, 1);

        $type->load($this->var);
        $this->assertNull($type->getValue());
        $this->assertNull($type->getKey());

        // not null key
        $type->load($var, $key);
        $this->assertNull($var);
        $this->assertSame($key, $type->getKey());
    }

    public function testInvalidValue()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $type = new Type\NullType();
        $type->load($var);
    }

}

class TestClass
{
    public $publicProperty;
    protected $protectedProperty;
}
