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

        $result = array();

        $gd_info = gd_info();
        $width = imagesx($var);
        $height = imagesy($var);
        $colors_palette = imagecolorstotal($var);
        $isTrueColor = imageistruecolor($var) ? true : false;

        ob_start();
        imagepng($var);
        $image = ob_get_clean();

        $gd_support = array();
        if ($gd_info['FreeType Support']) $gd_support[] = 'FreeType(' . $gd_info['FreeType Linkage'] . ')';
        if ($gd_info['T1Lib Support']) $gd_support[] = 'T1Lib';
        if ($gd_info['GIF Read Support'] || $gd_info['GIF Create Support']) {
            if ($gd_info['GIF Read Support'] && $gd_info['GIF Create Support']) $gd_support[] = 'GIF';
            elseif ($gd_info['GIF Read Support']) $gd_support[] = 'GIF(read)';
            elseif ($gd_info['GIF Create Support']) $gd_support[] = 'GIF(create)';
        }
        if ($gd_info['JPEG Support']) $gd_support[] = 'JPEG';
        if ($gd_info['PNG Support']) $gd_support[] = 'PNG';
        if ($gd_info['WBMP Support']) $gd_support[] = 'WBMP';
        if ($gd_info['XPM Support']) $gd_support[] = 'XPM';
        if ($gd_info['XBM Support']) $gd_support[] = 'XBM';
        if ($gd_info['JIS-mapped Japanese Font Support']) $gd_support[] = 'JIS-mapped Japanese Font';

        /** @var $gdCollection Type\Extended\CollectionType */
        $gdCollection = $this->extendedTypeFactory->factory('collection', $this->level);
        $gdCollection->setTitle('GD');
        $gdCollection->loadFromArray(array(
            $this->createTextType($gd_info['GD Version'], 'Version'),
            $this->createTextType(implode(', ', $gd_support), 'Support')
        ));
        $gdCollection->setLevel($this->level + 1);

        /** @var $imageCollection Type\Extended\CollectionType */
        $imageCollection = $this->extendedTypeFactory->factory('collection', $this->level);
        $imageCollection->setTitle('Image');
        $imageCollection->loadFromArray(array(
            $this->createTextType(sprintf('%sx%s (px)', $width, $height), 'Dimensions'),
            $this->createTextType($colors_palette, 'Colors palette'),
            $this->createTextType($isTrueColor, 'True color'),
            $this->createImageType($image, 'Image')
        ));
        $imageCollection->setLevel($this->level + 1);

        /** @var $collection Type\Extended\CollectionType */
        $collection = $this->extendedTypeFactory->factory('collection', $this->level);
        $collection->setTitle('Data');
        $collection->loadFromArray(array(
            'GD' => $gdCollection,
            'Image' => $imageCollection
        ));

        $collection->setLevel($this->level);

        return $collection;
    }
}
