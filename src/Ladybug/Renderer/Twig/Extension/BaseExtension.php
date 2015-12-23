<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Renderer\Twig\Extension;

use Twig_Extension;
use Twig_Environment;
use Twig_Error_Loader;
use Ladybug\Type\RenderizableTypeInterface;

class BaseExtension extends Twig_Extension
{

    /** @var string $format */
    protected $format;

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ladybug.base';
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'render_type',
                array($this, 'renderTypeFunction'),
                array('needs_environment' => true, 'is_safe' => array('html'))
            )
        );
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('repeat', array($this, 'getRepeat'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('pad', array($this, 'getPad')),
        );
    }

    public function renderTypeFunction(Twig_Environment $environment, RenderizableTypeInterface $var, $key = null, $visibility = null)
    {
        $parameters = array(
            'var' => $var,
            'level' => $var->getLevel(),
            'key' => $key,
            'visibility' => $visibility
        );

        try {
            $code = $environment->render($var->getTemplateName().'.'.$this->format.'.twig', $parameters);
        } catch (Twig_Error_Loader $e) {
            return null;
        }

        $code = str_replace(array('<script>', '</script>'), array('<ladybug_script>', '</ladybug_script>'), $code);

        return $code;
    }

    public function getRepeat($text, $times)
    {
        return str_repeat($text, $times);
    }

    public function getPad($text, $length)
    {
        return str_pad($text, $length);
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }
}
