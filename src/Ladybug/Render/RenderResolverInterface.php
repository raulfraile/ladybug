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

use Ladybug\Format\FormatInterface;

/**
 * RenderResolverInterface is the interface implemented by all render resolver classes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface RenderResolverInterface
{

    /**
     * Adds a new RenderInterface to the resolver
     * @param RenderInterface $render
     * @param string          $key
     */
    public function add(RenderInterface $render, $key);

    /**
     * Gets the appropiate render object for the given format
     * @param FormatInterface $format
     *
     * @return RenderInterface
     */
    public function resolve(FormatInterface $format);

}
