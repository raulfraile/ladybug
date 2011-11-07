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

class Ladybug_Extension_Resource_File extends Ladybug_Extension {
    
    public function dump($var) {
        $result = '';
        
        $stream_vars = stream_get_meta_data($var);
        $fstat = fstat($var);
        
        $result .= $this->ladybug->writeDepth() . '[file] => '.realpath($stream_vars['uri']) . Ladybug_Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[mode] => '.$fstat['mode'] .  Ladybug_Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[size] => '.$this->ladybug->formatSize($fstat['size']) . Ladybug_Dumper::CHAR_NEWLINE;
        
        return $result;
    }
}