<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Theme\Modern;

use Ladybug\Theme\AbstractTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Format;

/**
 * Modern theme class
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class ModernTheme extends AbstractTheme implements HtmlThemeInterface
{
    /**
     * Gets the theme name
     *
     * @return string
     */
    public function getName()
    {
        return 'Modern';
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
            '@BaseTheme/lib/bootstrap/css/bootstrap.min.css',
            '@BaseTheme/lib/codemirror/lib/codemirror.css',
            '@ModernTheme/css/tree.css'
        );
    }

    /**
     * Gets JS dependencies
     *
     * @return array
     */
    public function getHtmlJsDependencies()
    {
        return array(
            '@BaseTheme/lib/jquery/jquery.min.js',
            '@BaseTheme/lib/bootstrap/js/bootstrap.min.js',
            '@BaseTheme/lib/codemirror/lib/codemirror.js',
            '@BaseTheme/lib/codemirror/mode/clike/clike.js',
            '@BaseTheme/lib/codemirror/mode/css/css.js',
            '@BaseTheme/lib/codemirror/mode/htmlmixed/htmlmixed.js',
            '@BaseTheme/lib/codemirror/mode/htmlembedded/htmlembedded.js',
            '@BaseTheme/lib/codemirror/mode/javascript/javascript.js',
            '@BaseTheme/lib/codemirror/mode/php/php.js',
            '@BaseTheme/lib/codemirror/mode/xml/xml.js'
        );
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
