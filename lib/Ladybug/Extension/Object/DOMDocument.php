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

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

class DOMDocument extends ExtensionBase
{
    public function dump($var)
    {
        $var->formatOutput = true;
        $xml = htmlentities($var->saveXML());

        return $xml;
    }

}
