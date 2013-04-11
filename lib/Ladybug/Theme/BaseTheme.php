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
use Ladybug\Format\FormatInterface;
use Ladybug\Container;

abstract class BaseTheme implements ThemeInterface
{

    /** @var Container $container */
    protected $container;

    protected $formats;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getHtmlCssDependencies()
    {
        return array();
    }

    public function getHtmlJsDependencies()
    {
        return array();
    }

    public function supportsFormat(FormatInterface $format)
    {
        return in_array($format->getName(), static::getFormats());
    }


}
