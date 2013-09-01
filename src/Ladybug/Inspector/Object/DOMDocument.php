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
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Type;

class DOMDocument extends AbstractInspector
{

    public function accept(InspectorDataWrapper $data)
    {
        return InspectorInterface::TYPE_CLASS == $data->getType() && 'DOMDocument' === $data->getId();
    }

    public function getData(InspectorDataWrapper $data)
    {
        if (!$this->accept($data)) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        /** @var \DOMDocument $var */
        $var = $data->getData();

        $var->formatOutput = true;
        $xml = $var->saveXML();

        /** @var $code Type\Extended\CodeType */
        $code = $this->extendedTypeFactory->factory('code', $this->level);

        $code->setLanguage('xml');
        $code->setContent($xml);
        $code->setKey('Code');
        $code->setTitle('XML');

        return $code;
    }

}
