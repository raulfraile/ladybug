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

use Ladybug\Inspector\AbstractInspector;
use Ladybug\Inspector\InspectorInterface;
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Type;

class SplQueue extends AbstractInspector
{
    public function accept(InspectorDataWrapper $data)
    {
        return InspectorInterface::TYPE_CLASS == $data->getType() && 'SplQueue' === $data->getId();
    }

    public function getData(InspectorDataWrapper $data)
    {
        if (!$this->accept($data)) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        /** @var $var \SplQueue */

        $arrayData = iterator_to_array($data->getData());

        /** @var $collection Type\Extended\CollectionType */
        $collection = $this->extendedTypeFactory->factory('collection', $this->level);

        $collection->setTitle('Queue');

        foreach ($arrayData as $item) {
            $collection->add($this->typeFactory->factory($item, $this->level + 1));
        }

        return $collection;
    }

}
