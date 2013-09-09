<?php

namespace Ladybug\Tests\Environment;

use Ladybug\Environment;
use Ladybug\Format;

class CliEnvironmentTest extends \PHPUnit_Framework_TestCase
{

    /** @var Environment\CliEnvironment */
    protected $environment;

    public function testValidDetection()
    {
        $this->environment = new Environment\CliEnvironment('cli');
        $this->assertTrue($this->environment->supports());
        $this->assertEquals('Cli', $this->environment->getName());
    }

    public function testNotValidDetection()
    {
        $this->environment = new Environment\CliEnvironment('apache2handler');
        $this->assertFalse($this->environment->supports());
    }

    public function testDefaultFormatIsConsole()
    {
        $this->environment = new Environment\CliEnvironment('cli');
        $this->assertEquals(Format\ConsoleFormat::FORMAT_NAME, $this->environment->getDefaultFormat());
    }
}
