<?php

namespace Ladybug\Environment;

use Ladybug\Container;

class EnvironmentResolver
{

    /** @var array $environments */
    protected $environments = array();

    /**
     * @param EnvironmentInterface[] $environments
     */
    public function __construct()
    {
        /*foreach ($environments as $item) {
            $this->register($item);
        }*/
    }

    /**
     * Registers a new environment
     *
     * When resolving, this environment is preferred over previously registered ones.
     *
     * @param EnvironmentInterface $environment
     */
    public function register(EnvironmentInterface $environment)
    {
        array_unshift($this->environments, $environment);
    }

    /**
     * Resolve environment
     *
     * @return EnvironmentInterface
     */
    public function resolve()
    {
        foreach ($this->environments as $item) {
            /** @var EnvironmentInterface $item */

            if ($item->isActive()) {
                return $item;
            }
        }

    }
}
