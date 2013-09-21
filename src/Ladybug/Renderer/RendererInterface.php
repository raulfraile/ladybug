<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Renderer;

use Ladybug\Theme\ThemeInterface;

/**
 * RendererInterface is the interface implemented by all render classes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface RendererInterface
{

    /**
     * Gets the render response format
     *
     * @return string Response format name
     */
    public function getFormat();

    /**
     * Renders an array of nodes
     * @param array $nodes     Nodes to render
     * @param array $extraData Extra data
     *
     * @return mixed
     */
    public function render(array $nodes, array $extraData = array());

    /**
     * Sets the theme that will be used to render
     * @param \Ladybug\Theme\ThemeInterface $theme
     */
    public function setTheme(ThemeInterface $theme);

    /**
     * Sets global variables
     * @param array $globals
     */
    public function setGlobals(array $globals);
}
