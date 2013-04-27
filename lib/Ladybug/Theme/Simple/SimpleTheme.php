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

namespace Ladybug\Theme\Simple;

use Ladybug\Theme\BaseTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Theme\CliThemeInterface;

use Ladybug\Format;

class SimpleTheme extends BaseTheme implements ThemeInterface, HtmlThemeInterface, CliThemeInterface
{

    public function getName()
    {
        return 'Simple';
    }

    public function getParent()
    {
        return null;
    }

    public function getCliColors()
    {
        return array(
            't_string' => 'green',
            't_bool' => 'blue',
            't_float' => 'red',
            't_int' => 'red'
        );
    }

    public function getCliTags()
    {
        // TODO: Implement getCliTags() method.
    }

    public function getHtmlCssDependencies()
    {
        return array(
            '@SimpleTheme/css/styles.css'
        );
    }

    public function getFormats()
    {
        return array(
            Format\HtmlFormat::FORMAT_NAME,
            Format\ConsoleFormat::FORMAT_NAME,
            Format\TextFormat::FORMAT_NAME
        );
    }

}
