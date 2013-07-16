<?php

namespace Ladybug\Tests\Render;

use Ladybug\Render;
use Ladybug\Type;
use Symfony\Component\Console\Output\ConsoleOutput;
use \Mockery as m;

class ConsoleRenderTest extends \PHPUnit_Framework_TestCase
{

    /** @var Render\ConsoleRender $render */
    protected $render;

    public function setUp()
    {
        $consoleOutputMock = m::mock('Symfony\Component\Console\Output\ConsoleOutput');
        $consoleOutputMock->shouldReceive('writeln')->andReturnUsing(function($messages) {
            return $messages;
        });

        $this->render = new Render\ConsoleRender($consoleOutputMock);

        $themeMock = m::mock('Ladybug\Theme\Base\BaseTheme');
        $themeMock->shouldReceive('getName')->andReturn('Base');
        $themeMock->shouldReceive('getParent')->andReturn(null);
        $themeMock->shouldReceive('getCliColors')->andReturn(array());

        $formatMock = m::mock('Ladybug\Format\ConsoleFormat');
        $formatMock->shouldReceive('getName')->andReturn(\Ladybug\Format\ConsoleFormat::FORMAT_NAME);

        $this->render->setTheme($themeMock);
        $this->render->setFormat($formatMock);
    }

    public function testRender()
    {
        $type = new Type\IntType();
        $type->load(1);
        $result = $this->render->render(array($type));

        $this->assertEquals('int <t_int>1</t_int>' . "\n", $result);
    }

}
