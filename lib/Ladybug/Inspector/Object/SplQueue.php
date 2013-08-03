<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Object/SplQueue dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector\Object;

use Ladybug\Dumper;
use Ladybug\Inspector\AbstractInspector;
use Ladybug\Type;

class SplQueue extends AbstractInspector
{
    public function getData($var)
    {

        if (!$var instanceof \SplQueue) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        /** @var $var \SplQueue */

        $arrayData = iterator_to_array($var);

        $collection = new Type\Extended\CollectionType();
        $collection->setTitle(sprintf('Queue (%d)', count($arrayData)));

        foreach ($arrayData as $item) {
            $collection->add($this->typeFactory->factory($item, $this->level));
        }

        return $collection;
    }

}
