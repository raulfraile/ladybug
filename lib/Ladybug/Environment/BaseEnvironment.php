<?php

namespace Ladybug\Environment;

use Ladybug\Container;

abstract class BaseEnvironment implements EnvironmentInterface
{

    /** @var Container $container */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
