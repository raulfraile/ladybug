<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Oject/DomDocument dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Object\Symfony\Component\HttpFoundation;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

class ParameterBag extends ExtensionBase
{
    public function dump($var)
    {
        $result = array();
        $result['bag'] = $var->all();

        return $result;
    }

}
