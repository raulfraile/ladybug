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
 * HtmlThemeInterface is the interface implemented by all theme classes supporting the html format.
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface HtmlThemeInterface extends ThemeInterface
{
    /**
     * Gets CSS dependencies
     *
     * @return array
     */
    public function getHtmlCssDependencies();

    /**
     * Gets JS dependencies
     *
     * @return array
     */
    public function getHtmlJsDependencies();
}
