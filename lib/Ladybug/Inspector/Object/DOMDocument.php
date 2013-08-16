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
use Ladybug\Inspector\InspectorInterface;
use Ladybug\Type;

class DOMDocument extends AbstractInspector
{

    public function accept($var, $type = InspectorInterface::TYPE_CLASS)
    {
        return InspectorInterface::TYPE_CLASS == $type && $var instanceof \DOMDocument;
    }

    public function getData($var, $type = InspectorInterface::TYPE_CLASS)
    {
        if (!$this->accept($var, $type)) {
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
