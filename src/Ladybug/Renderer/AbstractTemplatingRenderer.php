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

use Twig_Loader_Filesystem;
use Twig_Environment;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Renderer\Twig\Extension\BaseExtension;
use Ladybug\Theme\ThemeResolver;

abstract class AbstractTemplatingRenderer extends AbstractRenderer
{

    /** @var Twig_Environment $templatingEngine */
    protected $templatingEngine;

    protected $isLoaded = false;

    protected function loadTemplatingEngine()
    {
        if (!$this->isLoaded) {
            $loader = new Twig_Loader_Filesystem($this->getPaths());

            $this->templatingEngine = new Twig_Environment($loader);

            $extension = $this->getExtension();
            $extension->setFormat(static::getFormat());

            $this->templatingEngine->addExtension($extension);

            $this->isLoaded = true;
        }
    }

    public function setGlobals(array $globals)
    {
        if (!$this->isLoaded) {
            $this->loadTemplatingEngine();
        }

        foreach ($globals as $key => $value) {
            $this->templatingEngine->addGlobal($key, $value);
        }

    }

    protected function getPaths()
    {
        $paths = array();

        $templatesDir = $this->theme->getTemplatesPath() . ucfirst(static::getFormat()) . '/';
        if (file_exists($templatesDir)) {
            $paths[] = $templatesDir;
        }

        // extension templates
        $extensionsDir = $templatesDir . 'Extension/';

        if (file_exists($extensionsDir)) {
            $paths[] = $extensionsDir;
        }

        // parent
        $parent = strtolower($this->theme->getParent());

        if (!empty($parent)) {

            $parentTheme = $this->themeResolver->getTheme($parent, static::getFormat());

            if ($parentTheme !== false) {
                $templatesDir = $parentTheme->getTemplatesPath() . ucfirst(static::getFormat()) . '/';

                if (file_exists($templatesDir)) {
                    $paths[] = $templatesDir;
                }

                $templatesDir .= 'Extension/';
                if (file_exists($templatesDir)) {
                    $paths[] = $templatesDir;
                }
            }
        }

        if (empty($paths)) {
            // no theme found, load simple theme

            $simpleTheme = $this->themeResolver->getTheme('simple', static::getFormat());

            $paths = $this->getPathsByTheme($simpleTheme);

            $this->theme = $simpleTheme;
        }

        return $paths;
    }

    protected function getPathsByTheme(ThemeInterface $theme)
    {
        $paths = array();

        $templatesDir = $theme->getTemplatesPath() . ucfirst(static::getFormat()) . '/';
        if (file_exists($templatesDir)) {
            $paths[] = $templatesDir;
        }

        // extension templates
        $extensionsDir = $templatesDir . 'Extension/';

        if (file_exists($extensionsDir)) {
            $paths[] = $extensionsDir;
        }

        return $paths;
    }

    protected function prefixResourcesPath(array $files)
    {
        $resourcesPath = $this->theme->getResourcesPath();

        return array_map(function ($path) use ($resourcesPath) {
            return $resourcesPath.$path;
        }, $files);
    }

    public function getExtension()
    {
        return new BaseExtension();
    }

}
