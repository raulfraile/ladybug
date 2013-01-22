<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Oject/SplMaxHeap dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Object;

class SplMaxHeap extends SplHeap
{
    public function dump($var)
    {
        return parent::dump($var);
    }

}
