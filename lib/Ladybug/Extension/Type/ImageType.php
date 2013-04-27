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

namespace Ladybug\Extension\Type;

class ImageType extends BaseType
{

    const TYPE_ID = 'image';

    protected $width;
    protected $height;

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function load($var, $key = null)
    {
        $this->data = base64_encode($var);
        $this->key = $key;
    }

    public static function create($var, $key = null)
    {
        $object = new static();
        $object->load($var, $key);

        return $object;
    }
}
