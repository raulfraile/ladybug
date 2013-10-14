<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Renderer;

use Ladybug\Theme\HtmlThemeInterface;
use Ladybug\Format\HtmlFormat;

/**
 * HtmlRenderer renders a collection of nodes in HTML
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class HtmlRenderer extends AbstractTemplatingRenderer
{

    public function getFormat()
    {
        return HtmlFormat::FORMAT_NAME;
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->loadTemplatingEngine();

        $extraData = array_merge($extraData, array('options' => $this->options));

        return $this->templatingEngine->render('layout.html.twig', array_merge(array(
            'nodes' => $nodes,
            'css' => $this->getCssContents(),
            'js' => $this->getJsContents()
        ), $extraData));
    }

    protected function getCssContents()
    {
        /** @var HtmlThemeInterface $theme */
        $theme = $this->theme;

        // check last modification
        $lastModification = 0;

        foreach ($theme->getHtmlCssDependencies() as $item) {
            $filename = $theme->getResourcesPath().$item;

            if (file_exists($filename)) {
                $lastModification = max($lastModification, filemtime($filename));
            }
        }

        // cache
        $cacheFile = sprintf('%s/ladybug_cache/theme/%s.css', sys_get_temp_dir(), $theme->getName());
        $lastModificationCache = file_exists($cacheFile) ? filemtime($cacheFile) : -1;

        if ($lastModification > $lastModificationCache) {
            $pce = new \CssEmbed\CssEmbed();

            $css = '';

            foreach ($theme->getHtmlCssDependencies() as $item) {
                $file = $theme->getResourcesPath().$item;

                $minCss = file_get_contents($file);

                $pce->setRootDir(dirname($file));

                $css .= $pce->embedString($minCss);
            }

            if (!is_dir(dirname($cacheFile))) {
                mkdir(dirname($cacheFile));
            }

            file_put_contents($cacheFile, $css);
        } else {
            $css = file_get_contents($cacheFile);
        }

        return $css;
    }

    protected function getJsContents()
    {
        /** @var HtmlThemeInterface $theme */
        $theme = $this->theme;

        // check last modification
        $lastModification = 0;
        foreach ($theme->getHtmlJsDependencies() as $item) {
            $lastModification = max($lastModification, filemtime($theme->getResourcesPath().$item));
        }

        // cache
        $cacheFile = sprintf('%s/ladybug_cache/theme/%s.js', sys_get_temp_dir(), $theme->getName());
        $lastModificationCache = file_exists($cacheFile) ? filemtime($cacheFile) : -1;

        if ($lastModification > $lastModificationCache) {
            $js = '';
            foreach ($theme->getHtmlJsDependencies() as $item) {
                $file = $theme->getResourcesPath().$item;

                $js .= file_get_contents($file);
            }

            if (!is_dir(dirname($cacheFile))) {
                mkdir(dirname($cacheFile));
            }

            file_put_contents($cacheFile, $js);
        } else {
            $js = file_get_contents($cacheFile);
        }

        return $js;
    }
}
