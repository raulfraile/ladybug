<?php

namespace Ladybug\Tests\Environment;

use Ladybug\Environment;
use Ladybug\Format;

class AjaxEnvironmentTest extends \PHPUnit_Framework_TestCase
{

    /** @var Environment\AjaxEnvironment */
    protected $environment;

    public function testValidDetection()
    {
        $this->environment = new Environment\AjaxEnvironment('XMLHttpRequest');
        $this->assertTrue($this->environment->supports());
        $this->assertEquals('Ajax', $this->environment->getName());
    }

    public function testNotValidDetection()
    {
        $this->environment = new Environment\AjaxEnvironment('');
        $this->assertFalse($this->environment->supports());
    }

    public function testDefaultFormatIsText()
    {
        $this->environment = new Environment\AjaxEnvironment('XMLHttpRequest');
        $this->assertEquals(Format\TextFormat::FORMAT_NAME, $this->environment->getDefaultFormat());
    }
}
