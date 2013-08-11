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

use Ladybug\Dumper;
use Ladybug\Inspector\AbstractInspector;
use Ladybug\Type;

class Gd extends AbstractInspector
{

    public function getData($var)
    {
        if (!is_resource($var) || get_resource_type($var) != 'gd') {
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
