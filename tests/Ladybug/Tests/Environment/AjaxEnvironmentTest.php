<?php

namespace Ladybug\Tests\Type;

use Ladybug\Environment;

class AjaxEnvironmentTest extends \PHPUnit_Framework_TestCase
{

    public function testEnvironmentDetector()
    {
        // valid detection
        $environment = new Environment\AjaxEnvironment('XMLHttpRequest');
        $this->assertTrue($environment->isActive());

        // invalid detection
        $environment = new Environment\AjaxEnvironment();
        $this->assertFalse($environment->isActive());
    }

}
