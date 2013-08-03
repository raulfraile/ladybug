<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Object/SplStack dumper
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

class SplStack extends AbstractInspector
{
    public function getData($var)
    {

        if (!$var instanceof \SplStack) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        /** @var $var \SplStack */

        $arrayData = iterator_to_array($var);

        $collection = new Type\Extended\CollectionType();
        $collection->setTitle(sprintf('Stack (%d)', count($arrayData)));

        foreach ($arrayData as $item) {
            $collection->add($this->typeFactory->factory($item, $this->level));
        }

        return $collection;
    }

}
