<?php

namespace Ladybug\Tests\Format;

use Ladybug\Format;
use \Mockery as m;

class JsonFormatTest extends \PHPUnit_Framework_TestCase
{

    /** @var Format\JsonFormat */
    protected $format;

    public function setUp()
    {
        $this->format = new Format\JsonFormat();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('json', $this->format->getName());
    }

}
