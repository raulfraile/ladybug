<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * ExtensionBase class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class TextType extends BaseType
{

    const TYPE_ID = 'text';

    public function getTemplateName()
    {
        return static::TYPE_ID;
    }

    public function load($var, $key = null)
    {
        $this->data = $var;
        $this->key = $key;
    }

    public static function create($var, $key = null, $level = 1)
    {
        $object = new static();
        $object->load($var, $key);
        $object->setLevel($level);

        return $object;
    }

    public function setText($text)
    {
        $this->data = $text;
    }

}
