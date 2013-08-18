<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Theme\Classic;

use Ladybug\Theme\AbstractTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Format;

/**
 * Classic theme class
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class ClassicTheme extends AbstractTheme implements HtmlThemeInterface
{

    /**
     * Gets the theme name
     *
     * @return string
     */
    public function getName()
    {
        return 'Classic';
    }

    /**
     * Gets the theme parent
     *
     * @return string
     */
    public function getParent()
    {
        return 'Base';
    }

    /**
     * Gets CSS dependencies
     *
     * @return array
     */
    public function getHtmlCssDependencies()
    {
        return array(
            '@ClassicTheme/css/styles.css'
        );
    }

    /**
     * Gets JS dependencies
     *
     * @return array
     */
    public function getHtmlJsDependencies()
    {
        return array();
    }

    /**
     * Gets supported formats
     *
     * @return array
     */
    public function getFormats()
    {
        return array(
            Format\HtmlFormat::FORMAT_NAME
        );
    }

}
