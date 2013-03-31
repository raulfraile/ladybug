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

use Ladybug\Theme\BaseTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;

class ModernTheme extends BaseTheme implements ThemeInterface, HtmlThemeInterface
{


    public function getName()
    {
        return 'Modern';
    }

    public function getParent()
    {
        return 'Simple';
    }


    public function getHtmlCssDependencies()
    {
        return array(
            '@SimpleTheme/lib/bootstrap/css/bootstrap.min.css',
            '@SimpleTheme/lib/codemirror/lib/codemirror.css',
            '@ModernTheme/css/styles.css'
        );
    }

    public function getHtmlJsDependencies()
    {
        return array(
            '@SimpleTheme/lib/jquery/jquery.min.js',
            '@SimpleTheme/lib/bootstrap/js/bootstrap.min.js',
            '@SimpleTheme/lib/codemirror/lib/codemirror.js',
            '@SimpleTheme/lib/codemirror/mode/xml/xml.js'
        );
    }

    function getEnvironments()
    {
        return array('Html');
    }
}
