<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Environment;

interface EnvironmentInterface
{
    /**
     * Gets environment name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns true if the environment supports the current request request
     *
     * @return mixed
     */
    public function supports();

    /**
     * Gets the default format for this environment
     *
     * @return string
     */
    public function getDefaultFormat();
}
