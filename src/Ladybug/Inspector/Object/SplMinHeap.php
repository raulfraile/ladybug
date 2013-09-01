<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Object/SplMinHeap dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector\Object;

use Ladybug\Inspector\InspectorInterface;
use Ladybug\Inspector\InspectorDataWrapper;

class SplMinHeap extends SplHeap
{
    public function accept(InspectorDataWrapper $data)
    {
        return InspectorInterface::TYPE_CLASS == $data->getType() && 'SplMinHeap' === $data->getId();
    }
}
