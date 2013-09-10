<?php

namespace Ladybug\Tests\Format;

use Ladybug\Format;
use \Mockery as m;

class YamlFormatTest extends \PHPUnit_Framework_TestCase
{

    /** @var Format\YamlFormat */
    protected $format;

    public function setUp()
    {
        $this->format = new Format\YamlFormat();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('yml', $this->format->getName());
    }

}
