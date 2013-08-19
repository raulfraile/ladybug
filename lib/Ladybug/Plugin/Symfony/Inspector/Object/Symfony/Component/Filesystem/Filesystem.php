<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Object/DomDocument dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Plugin\Symfony\Inspector\Object\Symfony\Component\Filesystem;

use Ladybug\Inspector\AbstractInspector;
use Ladybug\Inspector\InspectorInterface;
use Ladybug\Type;

class Filesystem extends AbstractInspector
{
    public function accept($var, $type = InspectorInterface::TYPE_CLASS)
    {
        return InspectorInterface::TYPE_CLASS == $type && $var instanceof \Symfony\Component\Filesystem\Filesystem;
    }

    public function getData($var, $type = InspectorInterface::TYPE_CLASS)
    {
        /** @var $var \Symfony\Component\Filesystem\Filesystem */

        /** @var $collection Type\Extended\CollectionType */
        $collection = $this->extendedTypeFactory->factory('collection', $this->level);

        $collection->setTitle('fs');
        $collection->add($this->createTextType('test', $this->level));

        return $collection;
    }

}
