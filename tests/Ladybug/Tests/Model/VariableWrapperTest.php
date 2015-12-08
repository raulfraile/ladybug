<?php

namespace Ladybug\Tests\Model;

use Ladybug\Model\VariableWrapper;
use \Mockery as m;

class VariableWrapperTest extends \PHPUnit_Framework_TestCase
{

    public function testObjectCreation()
    {
        $var = new \Ladybug\Type\IntType();
        $var->load(1);

        $variableWrapper = new VariableWrapper(1, $var, VariableWrapper::TYPE_CLASS);

        $this->assertInstanceOf('Ladybug\Model\VariableWrapper', $variableWrapper);
        $this->assertEquals(1, $variableWrapper->getId());
        $this->assertEquals($var, $variableWrapper->getData());
        $this->assertEquals(VariableWrapper::TYPE_CLASS, $variableWrapper->getType());
    }

}
