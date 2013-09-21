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

use Ladybug\Format\FormatInterface;

class RendererResolver implements RendererResolverInterface
{

    /** @var RendererInterface[] $renderers */
    protected $renderers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->renderers = array();
    }

    /**
     * Adds a new RendererInterface to the resolver
     * @param RendererInterface $render
     * @param string          $key
     */
    public function add(RendererInterface $render, $key)
    {
        $this->renderers[$key] = $render;
    }

    /**
     * Gets the appropriate render object for the given format
     * @param FormatInterface $format
     *
     * @throws \Exception
     * @return RendererInterface
     */
    public function resolve(FormatInterface $format)
    {
        foreach ($this->renderers as $render) {

            if ($render->getFormat() === $format->getName()) {
                return $render;
            }
        }

        throw new \Exception('Render not found');
    }

}
