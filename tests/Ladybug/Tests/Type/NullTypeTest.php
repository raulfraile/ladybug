<?php

namespace Ladybug\Tests\Type;

use Ladybug\Type;

class NullTypeTest extends \PHPUnit_Framework_TestCase
{

    protected $type;

    public function setUp()
    {
        $this->type = new Type\NullType();
    }

    public function testLoaderForValidValues()
    {
        $var = null;

        $this->type->load($var);
        $this->assertNull($this->type->getValue());
    }

    public function testLoaderForOtherType()
    {
        $this->setExpectedException('Ladybug\Type\Exception\InvalidVariableTypeException');

        $var = 'test';

        $this->type->load($var);
    }

}
