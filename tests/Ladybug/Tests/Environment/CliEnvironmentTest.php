<?php

namespace Ladybug\Tests\Type;

use Ladybug\Environment;

class CliEnvironmentTest extends \PHPUnit_Framework_TestCase
{

    public function testEnvironmentDetector()
    {
        // valid detection
        $environment = new Environment\CliEnvironment('cli');
        $this->assertTrue($environment->isActive());

        // invalid detection
        $environment = new Environment\CliEnvironment('apache2handler');
        $this->assertFalse($environment->isActive());
    }

}
