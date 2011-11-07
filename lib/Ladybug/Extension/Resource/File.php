<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Resources/File dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Resource;

use Ladybug\Dumper;
use Ladybug\Extension;

class File extends Extension {
    
    public function dump($var) {
        $result = '';
        
        $stream_vars = stream_get_meta_data($var);
        $fstat = fstat($var);
        
        $result .= $this->ladybug->writeDepth() . '[file] => '.realpath($stream_vars['uri']) . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[mode] => '.$fstat['mode'] .  Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[size] => '.$this->ladybug->formatSize($fstat['size']) . Dumper::CHAR_NEWLINE;
        
        return $result;
    }
}