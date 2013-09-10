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
use Ladybug\Format\HtmlFormat;

class HtmlRender extends AbstractTemplatingRender
{

    public function getFormat()
    {
        return HtmlFormat::FORMAT_NAME;
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->loadTemplatingEngine();

        /** @var HtmlThemeInterface $theme */
        $theme = $this->theme;

        return $this->templatingEngine->render('layout.html.twig', array_merge(array(
            'nodes' => $nodes,
            'css' => $this->prefixResourcesPath($theme->getHtmlCssDependencies()),
            'js' => $this->prefixResourcesPath($theme->getHtmlJsDependencies())
        ), $extraData));
    }
}
