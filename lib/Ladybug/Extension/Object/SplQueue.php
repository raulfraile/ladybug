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

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;
use Ladybug\Extension\Type;

class SplQueue extends ExtensionBase
{
    public function getData($var)
    {
        /** @var $var \SplQueue */

        $arrayData = iterator_to_array($var);

        $collection = new Type\CollectionType();
        $collection->setTitle(sprintf('Queue (%d)', count($arrayData)));

        foreach ($arrayData as $item) {
            $collection->add($this->factory->factory($item));
        }

        return $collection;
    }

}
