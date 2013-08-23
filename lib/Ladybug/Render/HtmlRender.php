<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Ladybug\Theme\HtmlThemeInterface;

class HtmlRender extends AbstractRender implements RenderInterface
{

    public function getFormat()
    {
        return self::FORMAT_HTML;
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->load();

        /** @var HtmlThemeInterface $theme */
        $theme = $this->theme;

        return $this->twig->render('layout.html.twig', array_merge(array(
            'nodes' => $nodes,
            'css' => $this->prefixResourcesPath($theme->getHtmlCssDependencies()),
            'js' => $this->prefixResourcesPath($theme->getHtmlJsDependencies())
        ), $extraData));
    }
}
