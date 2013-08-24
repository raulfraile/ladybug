<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class TextType extends AbstractType
{

    const TYPE_ID = 'text';

    protected $text;

    
/*
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
    }*/

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

}
