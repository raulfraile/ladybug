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

/**
 * ThemeInterface is the interface implemented by all theme classes.
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface ThemeInterface
{

    /**
     * Gets the theme name
     *
     * @return string
     */
    public function getName();

    /**
     * Gets the theme parent
     *
     * @return string
     */
    public function getParent();

    /**
     * Gets supported formats
     *
     * @return array
     */
    public function getFormats();

    public function getResourcesPath();
    public function getTemplatesPath();
}
