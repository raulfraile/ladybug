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

use Ladybug\Format;

/**
 * PhpRenderer serializes a collection of nodes in PHP
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class PhpRenderer extends AbstractRenderer
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
