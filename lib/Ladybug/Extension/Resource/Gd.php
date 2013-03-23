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
use Ladybug\Type;


class Gd extends ExtensionBase
{
    public function getData($var)
    {
        $result = array();

        $gd_info = gd_info();
        $width = imagesx($var);
        $height = imagesy($var);
        $colors_palette = imagecolorstotal($var);
        $is_true_color = imageistruecolor($var) ? 'TRUE' : 'FALSE';

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

        // gd info
        $result['GD'] = Type\FactoryType::factory(array(
            'version' => $gd_info['GD Version'],
            'support' => implode(', ', $gd_support)
        ), $this->container);

        // image info
        $result['image'] = Type\FactoryType::factory(array(
            'width' => Type\FactoryType::factory($width . 'px', $this->container),
            'height' => Type\FactoryType::factory($height . 'px', $this->container),
            'colors_palette' => Type\FactoryType::factory($colors_palette, $this->container),
            'true_color' => Type\FactoryType::factory($is_true_color, $this->container),
            //'image' =>'<br/><img style="border:1px solid #ccc; padding:1px" src="data:image/png;base64,' . base64_encode($image) . '" />'
            'image' => new Type\Extended\ImageType('data:image/png;base64,' . base64_encode($image), $this->container),
        ), $this->container);

        return $result;
    }
}
