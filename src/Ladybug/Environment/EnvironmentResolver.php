<?php

namespace Ladybug\Environment;

class EnvironmentResolver
{

    /** @var array $environments */
    protected $environments = array();

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
     * @return EnvironmentInterface|boolean
     */
    public function resolve()
    {
        foreach ($this->environments as $item) {
            /** @var EnvironmentInterface $item */

            if ($item->supports()) {
                return $item;
            }
        }

        return false;
    }
}
