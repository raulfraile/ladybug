<?php

namespace Ladybug\Tests\Format;

use Ladybug\Format;
use \Mockery as m;

class HtmlFormatTest extends \PHPUnit_Framework_TestCase
{

    /** @var Format\HtmlFormat */
    protected $format;

    public function setUp()
    {
        $this->format = new Format\HtmlFormat();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('html', $this->format->getName());
    }

}
