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
use Ladybug\Render\RenderInterface;

class RenderResolver implements RenderResolverInterface
{

    /** @var RenderInterface[] $renders */
    protected $renders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->renders = array();
    }

    /**
     * Adds a new RenderInterface to the resolver
     * @param RenderInterface $render
     * @param string          $key
     */
    public function add(RenderInterface $render, $key)
    {
        $this->renders[$key] = $render;
    }

    /**
     * Gets the appropiate render object for the given format
     * @param FormatInterface $format
     *
     * @throws \Exception
     * @return RenderInterface
     */
    public function resolve(FormatInterface $format)
    {
        foreach ($this->renders as $render) {

            if ($render->getFormat() === $format->getName()) {
                return $render;
            }
        }

        throw new \Exception('Render not found');
    }

}
