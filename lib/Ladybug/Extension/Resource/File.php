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
        $result = array();
        
        $stream_vars = stream_get_meta_data($var);
        $fstat = fstat($var);
        
        $result['File'] = realpath($stream_vars['uri']);
        $result['Mode'] = $fstat['mode'];
        $result['Size'] = $fstat['size'];
        
        return $result;
    }
}