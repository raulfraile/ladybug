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

    /** @var ConsoleOutput $consoleOutput */
    protected $consoleOutput;

    public function setUp()
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->consoleOutput->setVerbosity(0);
        $this->render = new Render\ConsoleRender($this->consoleOutput);

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
