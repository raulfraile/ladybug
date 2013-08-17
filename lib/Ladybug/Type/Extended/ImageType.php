<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * AbstractPlugin class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class ImageType extends BaseType
{

    const TYPE_ID = 'image';

    protected $width;
    protected $height;

    protected $tempPath;

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

    public function setImage($image)
    {
        $this->data = base64_encode($image);

        // create temp file
        $this->tempPath = sys_get_temp_dir() . '/' . uniqid('ladybug_');
        file_put_contents($this->tempPath, $image);
    }

    public function getTempPath()
    {
        return $this->tempPath;
    }

}
