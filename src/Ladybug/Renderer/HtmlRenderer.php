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
            $lastModification = max($lastModification, filemtime($theme->getResourcesPath().$item));
        }

        // cache
        $cacheFile = sprintf('%s/ladybug_cache/theme/5%s.css', sys_get_temp_dir(), $theme->getName());
        $lastModificationCache = file_exists($cacheFile) ? filemtime($cacheFile) : 0;

        if ($lastModification > $lastModificationCache) {
            $compressor = new \Jivaro\Compressor\Css();
            foreach ($theme->getHtmlCssDependencies() as $item) {
                $file = $theme->getResourcesPath().$item;

                $compressor
                    ->addFile($file)
                    ->embed(dirname($file));
            }

            $css = $compressor->getContents();

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
            $compressor = new \Jivaro\Compressor\JavaScript();
            foreach ($theme->getHtmlJsDependencies() as $item) {
                $file = $theme->getResourcesPath().$item;

                $compressor->addFile($file);
            }

            $js = $compressor->getContents();

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
