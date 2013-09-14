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
 * HtmlThemeInterface is the interface implemented by all theme classes supporting the console format.
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface CliThemeInterface extends ThemeInterface
{
    /**
     * Gets CLI styles
     *
     * @return array
     */
    public function getCliStyles();

    /**
     * Gets CLI tags
     *
     * @return array
     */
    public function getCliTags();
}
