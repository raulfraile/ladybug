<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/AbstractType: Base type
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
use Ladybug\Theme\ThemeInterface;
use Ladybug\Type\TypeInterface;
use Ladybug\Format\FormatInterface;
use Ladybug\Render\Twig\Extension\LadybugExtension;

abstract class BaseRender implements RenderInterface
{

    /** @var ThemeInterface $theme */
    protected $theme;

    /** @var Twig_Environment $twig */
    protected $twig;

    /** @var FormatInterface $format */
    protected $format;

    /**
     * @param ThemeInterface $theme
     */
    public function __construct(ThemeInterface $theme, FormatInterface $format)
    {
        $this->theme = $theme;
        $this->format = $format;

        $loader = new Twig_Loader_Filesystem($this->getPaths());

        $this->twig = new Twig_Environment($loader);

        /*$function = new Twig_SimpleFunction('include_file', function ($filename) use ($theme) {
            $filename = preg_replace('/^@([A-Za-z]+)Theme\//', __DIR__ . '/../Theme/\\1/Resources/', $filename);

            return file_get_contents($filename);
        });

        $this->twig->addFunction($function);*/


        $extension = new LadybugExtension();
        $extension->setFormat($this->format->getName());

        $this->twig->addExtension($extension);


    }

    public function render(array $nodes)
    {
        $content = '';

        foreach ($nodes as $item) {
            /** @var TypeInterface $item */

            $template = sprintf('%s.%s.twig', $item->getTemplateName(), $this->getFormat());
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

        $templatesDir = __DIR__ . '/../Theme/' . $this->theme->getName() . '/View/'.ucfirst($this->format->getName()).'/';

        if (file_exists($templatesDir)) {
            $paths[] = $templatesDir;
        }

        // extension templates
        $extensionsDir = __DIR__ . '/../Extension/Type/View/'.ucfirst($this->format->getName()).'/';
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

}
