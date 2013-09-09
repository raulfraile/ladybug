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

abstract class AbstractPlugin implements PluginInterface
{

    /**
     * Gets the configuration file path
     * @static
     *
     * @return string Configuration file path
     */
    public static function getConfigFile()
    {
        return __DIR__ . '/Config/services.xml';
    }

}
