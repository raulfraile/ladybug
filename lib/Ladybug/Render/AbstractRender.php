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

use Twig_Loader_Filesystem;
use Twig_Environment;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Format\FormatInterface;
use Ladybug\Render\Twig\Extension\LadybugExtension;

abstract class AbstractRender implements RenderInterface
{

    /** @var ThemeInterface $theme */
    protected $theme;

    /** @var Twig_Environment $twig */
    protected $twig;

    /** @var FormatInterface $format */
    protected $format;

    protected $isLoaded = false;

    protected function load()
    {
        if (!$this->isLoaded) {
            $loader = new Twig_Loader_Filesystem($this->getPaths());

            $this->twig = new Twig_Environment($loader);

            $extension = new LadybugExtension();
            $extension->setFormat($this->format->getName());

            $this->twig->addExtension($extension);

            $this->isLoaded = true;
        }
    }

    public function setGlobals(array $globals)
    {
        if (!$this->isLoaded) {
            $this->load();
        }

        foreach ($globals as $key => $value) {
            $this->twig->addGlobal($key, $value);
        }

    }

    protected function getPaths()
    {
        $paths = array();

        $templatesDir = __DIR__ . '/../Theme/' . $this->theme->getName() . '/View/'.ucfirst($this->format->getName()).'/';

        if (file_exists($templatesDir)) {
            $paths[] = $templatesDir;
        }

        // extension templates
        $extensionsDir = __DIR__ . '/../Theme/' . $this->theme->getName() . '/View/'.ucfirst($this->format->getName()).'/Extension';

        if (file_exists($extensionsDir)) {
            $paths[] = $extensionsDir;
        }

        // parent
        $parent = $this->theme->getParent();
        if (!is_null($parent)) {
            $templatesDir = __DIR__ . '/../Theme/' . $parent . '/View/'.ucfirst($this->format->getName()).'/';
            if (file_exists($templatesDir)) {
                $paths[] = $templatesDir;
            }

            $templatesDir .= 'Extension/';
            if (file_exists($templatesDir)) {
                $paths[] = $templatesDir;
            }
        }

        return $paths;
    }

    /**
     * @param \Ladybug\Format\FormatInterface $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return \Ladybug\Format\FormatInterface
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param \Ladybug\Theme\ThemeInterface $theme
     */
    public function setTheme(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return \Ladybug\Theme\ThemeInterface
     */
    public function getTheme()
    {
        return $this->theme;
    }

}
