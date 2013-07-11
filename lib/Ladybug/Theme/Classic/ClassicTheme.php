<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/AbstractType: Base type
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Theme\Classic;

use Ladybug\Theme\AbstractTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Format;

class ClassicTheme extends AbstractTheme implements ThemeInterface, HtmlThemeInterface
{

    public function getName()
    {
        return 'Classic';
    }

    public function getParent()
    {
        return 'Base';
    }

    public function getHtmlCssDependencies()
    {
        return array(
            '@ClassicTheme/css/styles.css'
        );
    }

    public function getHtmlJsDependencies()
    {
        return array();
    }

    public function getFormats()
    {
        return array(
            Format\HtmlFormat::FORMAT_NAME
        );
    }

}
