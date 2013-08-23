<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Theme;

abstract class AbstractTheme implements ThemeInterface
{

    protected $path;

    public function __construct($path = null)
    {
        $this->path = (!is_null($path)) ? $path : __DIR__ . '/' . $this->getName();
    }

    public function getResourcesPath()
    {
        return $this->path . '/Resources/';
    }

    public function getTemplatesPath()
    {
        return $this->path . '/View/';
    }

}
