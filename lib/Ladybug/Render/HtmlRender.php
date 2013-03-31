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

namespace Ladybug\Render;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;
use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Type\TypeInterface;

class HtmlRender extends BaseRender implements RenderInterface
{

    public function getFormat()
    {
        return self::FORMAT_HTML;
    }

    public function render(array $nodes)
    {
        $result = $this->twig->render('layout.html.twig', array(
            'nodes' => $nodes,
            'css' => $this->theme->getHtmlCssDependencies(),
            'js' => $this->theme->getHtmlJsDependencies()
        ));

        return $result;
    }
}
