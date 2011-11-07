<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Mysql/Link dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Resource;

use Ladybug\Dumper;
use Ladybug\Extension;

class Mysqllink extends Extension {
    
    
    public function dump($var) {
        $result = '';
        
        $result .= $this->ladybug->writeDepth() . '[Host info] => ' . mysql_get_host_info($var) . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[MySQL protocol version] => ' . mysql_get_proto_info($var) . Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[MySQL server version] => ' . mysql_get_server_info($var) . Dumper::CHAR_NEWLINE;
        
        return $result;
    }
}