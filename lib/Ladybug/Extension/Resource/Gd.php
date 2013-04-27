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

namespace Ladybug\Extension\Resource;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

use Ladybug\Extension\Type;

class Gd extends ExtensionBase
{
    public function getData($var)
    {
        $result = array();

        $gd_info = gd_info();
        $width = imagesx($var);
        $height = imagesy($var);
        $colors_palette = imagecolorstotal($var);
        $is_true_color = imageistruecolor($var) ? true : false;

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

        $gdCollection = new Type\CollectionType();
        $gdCollection->setTitle('GD');
        $gdCollection->loadFromArray(array(
            Type\TextType::create($gd_info['GD Version'], 'version'),
            Type\TextType::create(implode(', ', $gd_support), 'support')
        ));

        $imageCollection = new Type\CollectionType();
        $imageCollection->setTitle('Image');
        $imageCollection->loadFromArray(array(
            Type\TextType::create(sprintf('%sx%s (px)', $width, $height), 'dimensions'),
            Type\TextType::create($colors_palette, 'colors palette'),
            $this->factory->factory($is_true_color, 'true color'),
            Type\ImageType::create($image, 'Image'),
        ));

        $collection = new Type\CollectionType($result);
        $collection->setTitle('Data');
        $collection->loadFromArray(array(
            'GD' => $gdCollection,
            'Image' => $imageCollection
        ));

        return $collection;
    }
}
