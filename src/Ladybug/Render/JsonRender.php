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

class JsonRender extends AbstractRender implements RenderInterface
{

    public function getFormat()
    {
        return \Ladybug\Format\JsonFormat::FORMAT_NAME;
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->load();

        return $this->getSerializer()->serialize($nodes, $this->getFormat());
    }
}
