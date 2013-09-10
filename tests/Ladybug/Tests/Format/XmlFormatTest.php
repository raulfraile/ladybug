<?php

namespace Ladybug\Tests\Format;

use Ladybug\Format;
use \Mockery as m;

class XmlFormatTest extends \PHPUnit_Framework_TestCase
{

    /** @var Format\XmlFormat */
    protected $format;

    public function setUp()
    {
        $this->format = new Format\XmlFormat();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('xml', $this->format->getName());
    }

}
