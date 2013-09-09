<?php

namespace Ladybug\Tests\Environment;

use Ladybug\Environment;
use Ladybug\Format;

class BrowserEnvironmentTest extends \PHPUnit_Framework_TestCase
{

    /** @var Environment\AjaxEnvironment */
    protected $environment;

    public function setUp()
    {
        $this->environment = new Environment\BrowserEnvironment();
    }

    public function testValidDetection()
    {
        $this->assertTrue($this->environment->supports());
        $this->assertEquals('Browser', $this->environment->getName());
    }

    public function testDefaultFormatIsHtml()
    {
        $this->assertEquals(Format\HtmlFormat::FORMAT_NAME, $this->environment->getDefaultFormat());
    }
}
