<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Ladybug\Format\FormatInterface;
use Ladybug\Theme\ThemeInterface;

class FactoryRender
{

    protected $renders;

    public function __construct()
    {
        $this->renders = array();
    }

    public function add(RenderInterface $render, $key)
    {
        $this->renders[$key] = $render;
    }

    public function factory(ThemeInterface $theme, FormatInterface $format)
    {
        return $this->renders['render_'.$format->getName()];
    }

}
