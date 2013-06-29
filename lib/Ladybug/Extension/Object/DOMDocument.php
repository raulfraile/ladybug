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
        /** @var \DOMDocument $var */

        $var->formatOutput = true;
        $xml = $var->saveXML();

        $result = new Type\CodeType();
        $result->setLanguage('xml');
        $result->setData($xml);
        $result->setKey('Code');
        $result->setLevel($this->level);

        return $result;
    }

}
