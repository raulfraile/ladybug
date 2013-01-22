<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Oject/SplQueue dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

class SplQueue extends ExtensionBase
{
    public function dump($var)
    {
        /** @var $var \SplQueue */

        $result = array(
            'Count' => count($var),
            'Queue' => iterator_to_array($var)
        );

        return $result;
    }

}
