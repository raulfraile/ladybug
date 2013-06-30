<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/BaseType: Base type
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Theme\Modern;

use Ladybug\Theme\AbstractTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Format;

class ModernTheme extends AbstractTheme implements ThemeInterface, HtmlThemeInterface
{

    public function getName()
    {
        return 'Modern';
    }

    public function getParent()
    {
        return 'Base';
    }

    public function getHtmlCssDependencies()
    {
        return array(
            '@BaseTheme/lib/bootstrap/css/bootstrap.min.css',
            '@BaseTheme/lib/codemirror/lib/codemirror.css',
            '@ModernTheme/css/tree.css'
        );
    }

    public function getHtmlJsDependencies()
    {
        return array(
            '@BaseTheme/lib/jquery/jquery.min.js',
            '@BaseTheme/lib/bootstrap/js/bootstrap.min.js',
            '@BaseTheme/lib/codemirror/lib/codemirror.js',
            '@BaseTheme/lib/codemirror/mode/xml/xml.js'
        );
    }

    public function getFormats()
    {
        return array(
            Format\HtmlFormat::FORMAT_NAME
        );
    }
}
