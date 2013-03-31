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

namespace Ladybug\Theme;

use Ladybug\Render\RenderInterface;

abstract class BaseTheme implements ThemeInterface
{



    public function __construct()
    {

    }

    public function getHtmlCssDependencies()
    {
        return array();
    }

    public function getHtmlJsDependencies()
    {
        return array();
    }


}
