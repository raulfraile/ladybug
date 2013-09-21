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
 * Plugin classes can extend from this class to get some common methods
 */
abstract class AbstractPlugin implements PluginInterface
{

    /**
     * @inheritdoc
     */
    public static function getConfigFile()
    {
        return __DIR__ . '/Config/services.xml';
    }

    /**
     * @inheritdoc
     */
    public static function registerHelpers()
    {
        return array();
    }


}
