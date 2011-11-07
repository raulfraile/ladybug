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
use Ladybug\Extension;

class Gd extends Extension {
    
    public function dump($var) {
        $result = '';
        
        $gd_info = gd_info();
        $width = imagesx($var);
        $height = imagesy($var);
        $colors_palette = imagecolorstotal($var);
        $is_true_color = imageistruecolor($var) ? 'TRUE' : 'FALSE';
        
        ob_start();
        imagepng($var);
        $image = ob_get_clean();

        $gd_support = array();
        if ($gd_info['FreeType Support']) $gd_support[] = 'FreeType[' . $gd_info['FreeType Linkage'] . ']';
        if ($gd_info['T1Lib Support']) $gd_support[] = 'T1Lib';
        if ($gd_info['GIF Read Support'] || $gd_info['GIF Create Support']) {
            if ($gd_info['GIF Read Support'] && $gd_info['GIF Create Support']) $gd_support[] = 'GIF';
            elseif ($gd_info['GIF Read Support']) $gd_support[] = 'GIF[read]';
            elseif ($gd_info['GIF Create Support']) $gd_support[] = 'GIF[create]';
        }
        if ($gd_info['JPEG Support']) $gd_support[] = 'JPEG';
        if ($gd_info['PNG Support']) $gd_support[] = 'PNG';
        if ($gd_info['WBMP Support']) $gd_support[] = 'WBMP';
        if ($gd_info['XPM Support']) $gd_support[] = 'XPM';
        if ($gd_info['XBM Support']) $gd_support[] = 'XBM';
        if ($gd_info['JIS-mapped Japanese Font Support']) $gd_support[] = 'JIS-mapped Japanese Font';
        
        // gd info
        $result .= $this->ladybug->writeDepth() . '[gd] => [' . Dumper::CHAR_NEWLINE;
        Dumper::$depth++;
        $result .= $this->ladybug->writeDepth() . '[version] => ' . $gd_info['GD Version'] . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[support] => ' . implode(', ', $gd_support) . Dumper::CHAR_NEWLINE;
        Dumper::$depth--;
        $result .= $this->ladybug->writeDepth() . ']' . Dumper::CHAR_NEWLINE;
        
        // image info
        $result .= $this->ladybug->writeDepth() . '[width] => ' . $width . 'px' . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[height] => ' . $height . 'px' . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[colors_palette] => ' . $colors_palette . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[true_color] => ' . $is_true_color . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[image] =>' . Dumper::CHAR_NEWLINE . 
                   $this->ladybug->writeDepth() . $this->ladybug->writeDepth() . '<img style="border:1px solid #ccc; padding:1px" src="data:image/png;base64,' . base64_encode($image) . '" />' . Dumper::CHAR_NEWLINE;

        return $result;
    }
}