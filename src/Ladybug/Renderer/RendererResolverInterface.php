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

/**
 * RendererResolverInterface is the interface implemented by all render resolver classes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface RendererResolverInterface
{

    /**
     * Adds a new RendererInterface to the resolver
     * @param RendererInterface $render
     * @param string          $key
     */
    public function add(RendererInterface $render, $key);

    /**
     * Gets the appropriate render object for the given format
     * @param FormatInterface $format
     *
     * @return RendererInterface
     */
    public function resolve(FormatInterface $format);

}
