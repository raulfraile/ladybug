<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Oject/SplStack dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

class SplStack extends ExtensionBase
{
    public function dump($var)
    {
        /** @var $var \SplStack */

        $result = array(
            'Count' => count($var),
            'Stack' => iterator_to_array($var)
        );

        return $result;
    }

}
