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

class RenderResolver
{

    protected $renders;

    public function __construct()
    {
        $this->renders = array();
    }

    public function add(RenderInterface $render, $key)
    {
        $this->renders[$key] = $render;
    }

    /**
     * @param $format
     * @return RenderInterface
     * @throws \Exception
     */
    public function resolve(FormatInterface $format)
    {
        foreach ($this->renders as $render) {
            /** @var RenderInterface $render */

            if ($render->getFormat() === $format->getName()) {
                return $render;
            }
        }

        throw new \Exception('Render not found');
    }

}
