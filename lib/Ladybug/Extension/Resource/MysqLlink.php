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

class Ladybug_Extension_Resource_Mysqllink extends Ladybug_Extension {
    
    
    public function dump($var) {
        $result = '';
        
        $result .= $this->ladybug->writeDepth() . '[Host info] => ' . mysql_get_host_info($var) . Ladybug_Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[MySQL protocol version] => ' . mysql_get_proto_info($var) . Ladybug_Dumper::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[MySQL server version] => ' . mysql_get_server_info($var) . Ladybug_Dumper::CHAR_NEWLINE;
        
        return $result;
    }
}