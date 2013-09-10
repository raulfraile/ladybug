<?php

namespace Ladybug\Tests\Format;

use Ladybug\Format;
use \Mockery as m;

class TextFormatTest extends \PHPUnit_Framework_TestCase
{

    /** @var Format\TextFormat */
    protected $format;

    public function setUp()
    {
        $this->format = new Format\TextFormat();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('text', $this->format->getName());
    }

}
