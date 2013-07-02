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

namespace Ladybug\Inspector\Object\Symfony\Component\HttpFoundation;

use Ladybug\Dumper;
use Ladybug\Inspector\AbstractInspector;

class ParameterBag extends AbstractInspector
{
    public function getData($var)
    {
        $result = array();
        $result['bag'] = $var->all();

        return $result;
    }

}
