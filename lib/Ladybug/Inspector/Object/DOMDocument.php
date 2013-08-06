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

namespace Ladybug\Inspector\Object;

use Ladybug\Inspector\AbstractInspector;
use Ladybug\Type;

class DOMDocument extends AbstractInspector
{

    /**
     * @param  string                          $var
     * @return \Ladybug\Type\Extended\CodeType
     */
    public function getData($var)
    {
        if (!$var instanceof \DOMDocument) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        /** @var \DOMDocument $var */

        $var->formatOutput = true;
        $xml = $var->saveXML();

        /** @var $code Type\Extended\CodeType */
        $code = $this->extendedTypeFactory->factory('code', $this->level);

        $code->setLanguage('xml');
        $code->setData($xml);
        $code->setKey('Code');
        $code->setTitle('XML');

        return $code;
    }

}
