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

/**
 * RenderInterface is the interface implemented by all render classes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface RenderInterface
{

    const FORMAT_HTML = 'html';
    const FORMAT_CONSOLE = 'console';
    const FORMAT_TEXT = 'text';

    public function getFormat();

    public function render(array $nodes, array $extraData = array());

    public function setTheme(\Ladybug\Theme\ThemeInterface $theme);

    public function setFormat($format);

    public function setGlobals(array $globals);
}
