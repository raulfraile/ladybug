<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Plugin;

/**
 * PluginInterface is the interface implemented by all plugin classes
 */
interface PluginInterface
{
    /**
     * Gets the configuration file path
     * @static
     *
     * @return string Configuration file path
     */
    public static function getConfigFile();

    /**
     * Registers custom helpers
     * @static
     * @return array
     */
    public static function registerHelpers();
}
