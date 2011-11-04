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

require_once __DIR__.'/../Ladybug.php';
require_once __DIR__.'/../LadybugExtension.php';

class Ladybug_Resources_File extends LadybugExtension {
    
    public function dump($var) {
        $result = '';
        
        $stream_vars = stream_get_meta_data($var);
        $fstat = fstat($var);
        
        $result .= $this->ladybug->writeDepth() . '[file] => '.realpath($stream_vars['uri']) . Ladybug::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[mode] => '.$fstat['mode'] .  Ladybug::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[size] => '.$this->ladybug->formatSize($fstat['size']) . Ladybug::CHAR_NEWLINE;
        
        return $result;
    }
}