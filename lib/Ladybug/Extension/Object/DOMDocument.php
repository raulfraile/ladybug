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

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;
use Ladybug\Extension\Type;

class DOMDocument extends ExtensionBase
{
    public function getData($var)
    {
        $var->formatOutput = true;
        $xml = htmlentities($var->saveXML());

        $result = new Type\CodeType($xml);
        $result->setLanguage('xml');

        return array($result);
    }

}
