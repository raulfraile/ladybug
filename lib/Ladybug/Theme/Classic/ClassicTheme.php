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

namespace Ladybug\Theme\Classic;

use Ladybug\Theme\BaseTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Theme\CliThemeInterface;
use Ladybug\Format;

class ClassicTheme extends BaseTheme implements ThemeInterface, HtmlThemeInterface
{


    public function getName()
    {
        return 'Classic';
    }

    public function getParent()
    {
        return 'Simple';
    }


    public function getHtmlCssDependencies()
    {
        return array(
            '@ClassicTheme/css/styles.css'
        );
    }

    function getFormats()
    {
        return array(
            Format\HtmlFormat::FORMAT_NAME
        );
    }

}
