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

        $gdCollection = new Type\Extended\CollectionType();
        $gdCollection->setTitle('GD');
        $gdCollection->loadFromArray(array(
            Type\Extended\TextType::create($gd_info['GD Version'], 'Version'),
            Type\Extended\TextType::create(implode(', ', $gd_support), 'Support')
        ));
        $gdCollection->setLevel($this->level + 1);

        $imageCollection = new Type\Extended\CollectionType();
        $imageCollection->setTitle('Image');
        $imageCollection->loadFromArray(array(
            Type\Extended\TextType::create(sprintf('%sx%s (px)', $width, $height), 'Dimensions'),
            Type\Extended\TextType::create($colors_palette, 'Colors palette'),
            Type\Extended\TextType::create($isTrueColor, 'True color'),
            Type\Extended\ImageType::create($image, 'Image'),
        ));
        $imageCollection->setLevel($this->level + 1);

        $collection = new Type\Extended\CollectionType($result);
        $collection->setTitle('Data');
        $collection->loadFromArray(array(
            'GD' => $gdCollection,
            'Image' => $imageCollection
        ));

        $collection->setLevel($this->level);

        return $collection;
    }
}
