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

use Ladybug\Format;

class PhpRender extends AbstractRender
{

    public function render(array $nodes, array $extraData = array())
    {
        return array_merge(array(
            'nodes' => $nodes
        ), $extraData);
    }

    public function getFormat()
    {
        return Format\PhpFormat::FORMAT_NAME;
    }

}
