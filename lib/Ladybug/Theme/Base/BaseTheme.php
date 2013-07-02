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

namespace Ladybug\Theme\Base;

use Ladybug\Theme\AbstractTheme;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Theme\CliThemeInterface;

use Ladybug\Format;

class BaseTheme extends AbstractTheme implements ThemeInterface, HtmlThemeInterface, CliThemeInterface
{

    public function getName()
    {
        return 'Base';
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
            't_int' => 'red',
            't_array' => 'cyan',
            't_object' => 'cyan',
            't_resource' => 'cyan',
            't_array_block' => array('white', 'magenta'),
            'v_public' => 'green',// array('white', 'green'),
            'v_protected' => 'yellow',// array('white', 'yellow'),
            'v_private' => 'red',// array('white', 'red'),
            'f_tab' => 'white'
        );
    }

    public function getCliTags()
    {
        // TODO: Implement getCliTags() method.
    }

    public function getHtmlCssDependencies()
    {
        return array(
            '@BaseTheme/css/styles.css'
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
