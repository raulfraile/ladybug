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

abstract class BaseRender implements RenderInterface
{

    /** @var HtmlThemeInterface $theme */
    protected $theme;

    /** @var Twig_Environment $twig */
    protected $twig;

    /**
     * @param \Ladybug\Theme\HtmlThemeInterface $theme
     */
    public function __construct(HtmlThemeInterface $theme)
    {
        $this->theme = $theme;


        $loader = new Twig_Loader_Filesystem($this->getPaths());

        //$loader = new Twig_Loader_Filesystem(__DIR__ . '/../Theme/');

        $this->twig = new Twig_Environment($loader);

        $function = new Twig_SimpleFunction('include_file', function ($filename) use ($theme) {
            $filename = preg_replace('/^@([A-Za-z]+)Theme\//', __DIR__ . '/../Theme/\\1/Resources/', $filename);

            return file_get_contents($filename);
        });

        $this->twig->addFunction($function);

        $twig = $this->twig;
        $format = static::getFormat();
        $function2 = new Twig_SimpleFunction('render_type', function (TypeInterface $var) use ($twig, $format) {
            return $twig->render($var->getName().'.'.$format.'.twig', $var->getParameters());
        });

        $this->twig->addFunction($function2);

    }

    public function render(array $nodes)
    {
        $content = '';

        foreach ($nodes as $item) {
            /** @var TypeInterface $item */

            $template = sprintf('t_%s.%s.twig', $item->getName(), $this->getFormat());
            $content .= $this->twig->render($template, $item->getParameters());
        }

        $layoutTemplate = sprintf('layout.%s.twig', $this->getFormat());

        $result = $this->twig->render($layoutTemplate, array(
            'content' => $content,
            'nodes' => $nodes,
            'css' => $this->theme->getHtmlCssDependencies(),
            'js' => $this->theme->getHtmlJsDependencies()
        ));

        return $result;
    }

    protected function getPaths()
    {
        $paths = array();

        $templatesDir = __DIR__ . '/../Theme/' . $this->theme->getName() . '/View/'.ucfirst(static::getFormat()).'/';
        if (file_exists($templatesDir)) {
            $paths[] = $templatesDir;
        }

        // parents
        $currentTheme = $this->theme;
        while (!is_null($currentTheme->getParent())) {
            $templatesDir = __DIR__ . '/../Theme/' . $currentTheme->getParent() . '/View/'.ucfirst(static::getFormat()).'/';;
            if (file_exists($templatesDir)) {
                $paths[] = $templatesDir;
            }

            $themeClass = 'Ladybug\\Theme\\' . $currentTheme->getParent() . '\\' . $currentTheme->getParent() . 'Theme';
            $currentTheme = new $themeClass;

        }

        return $paths;
    }

}
