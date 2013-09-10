<?php

namespace Ladybug\Tests\Format;

use Ladybug\Format;
use \Mockery as m;

class PhpFormatTest extends \PHPUnit_Framework_TestCase
{

    /** @var Format\PhpFormat */
    protected $format;

    public function setUp()
    {
        $this->format = new Format\PhpFormat();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('php', $this->format->getName());
    }

}
