<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Oject/SplHeap dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

abstract class SplHeap extends ExtensionBase
{
    public function dump($var)
    {
        /** @var $var \SplHeap */

        $result = array(
            'Count' => count($var),
            'Heap' => iterator_to_array($var)
        );

        return $result;
    }

}
