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

require_once __DIR__.'/../Ladybug.php';
require_once __DIR__.'/../LadybugExtension.php';

class Ladybug_Resources_Mysql_Link extends LadybugExtension {
    
    
    public function dump($var) {
        $result = '';
        
        $result .= $this->ladybug->writeDepth() . '[Host info] => ' . mysql_get_host_info($var) . Ladybug::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[MySQL protocol version] => ' . mysql_get_proto_info($var) . Ladybug::CHAR_NEWLINE;
        $result .= $this->ladybug->writeDepth() . '[MySQL server version] => ' . mysql_get_server_info($var) . Ladybug::CHAR_NEWLINE;
        
        return $result;
    }
}