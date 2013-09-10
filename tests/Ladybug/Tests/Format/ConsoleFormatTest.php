<?php

namespace Ladybug\Tests\Format;

use Ladybug\Format;
use \Mockery as m;

class ConsoleFormatTest extends \PHPUnit_Framework_TestCase
{

    /** @var Format\ConsoleFormat */
    protected $format;

    public function setUp()
    {
        $this->format = new Format\ConsoleFormat();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('console', $this->format->getName());
    }

}
