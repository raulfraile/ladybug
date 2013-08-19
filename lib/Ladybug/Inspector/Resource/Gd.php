<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * GD dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector\Resource;

use Ladybug\Inspector\AbstractInspector;
use Ladybug\Inspector\InspectorInterface;

class Gd extends AbstractInspector
{

    public function accept($var, $type = InspectorInterface::TYPE_CLASS)
    {
        return InspectorInterface::TYPE_RESOURCE == $type && is_resource($var) && 'gd' === get_resource_type($var);
    }

    public function getData($var, $type = InspectorInterface::TYPE_CLASS)
    {
        if (!$this->accept($var, $type)) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        $width = imagesx($var);
        $height = imagesy($var);

        // get image content
        ob_start();
        imagepng($var);
        $imageContent = ob_get_clean();

        $image = $this->createImageType($imageContent, 'Image');
        $image->setLevel($this->level);
        $image->setWidth($width);
        $image->setHeight($height);
        $image->setTitle('Image');

        return $image;
    }
}
