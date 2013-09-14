<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render\Twig\Extension;

use Twig_Extension;
use Twig_Environment;
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
            'render_type' => new \Twig_Function_Method(
                $this,
                'renderTypeFunction',
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
            'repeat' => new \Twig_Filter_Method(
                $this,
                'getRepeat',
                array()
            ),
            'pad' => new \Twig_Filter_Method(
                $this,
                'getPad',
                array()
            )
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

        $code = $environment->render($var->getTemplateName().'.'.$this->format.'.twig', $parameters);

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
