<?php

namespace Ladybug\Tests\Render;

use Ladybug\Render;
use Ladybug\Type;
use \Mockery as m;

class HtmlRenderTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testEnvironmentDetector()
    {
        $themeMock = m::mock('Ladybug\Theme\Simple\SimpleTheme')
            ->shouldReceive('getName')
            ->andReturn('Simple')
            ->mock();
        $formatMock = m::mock('Ladybug\Format\HtmlFormat')
            ->shouldReceive('getName')
            ->andReturn('Html')
            ->mock();

        $render = new Render\HtmlRender($themeMock, $formatMock);

    }

}
