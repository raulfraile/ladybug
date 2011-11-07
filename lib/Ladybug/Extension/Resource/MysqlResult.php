<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Mysql/Result dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Resource;

use Ladybug\Dumper;
use Ladybug\Extension;

class Mysqlresult extends Extension {
    
    const CHAR_SEPARATOR = ' | ';
    const MAX_RESULTS = 50;
    
    public function dump($var) {
        $result = '';
        $i = 1;
        $column_names = array();
        
        while ($row = mysql_fetch_assoc($var)) {
            $result .= $this->ladybug->writeDepth() . '[' . $i . '] => ';
            $values = array();
            foreach ($row as $k => $v) {
                if ($i == 1) $column_names[] = $k;
                $values[] = $v;
            }
            $result .= implode(self::CHAR_SEPARATOR, $values) . Dumper::CHAR_NEWLINE;
            $i++;
            
            if ($i > self::MAX_RESULTS) {
                $result .= $this->ladybug->writeDepth() . '[...] => '. (mysql_num_rows($var) - self::MAX_RESULTS) . ' more results' . Dumper::CHAR_NEWLINE;
                break;
            }
        }
        
        // column names
        $result_with_names = $this->ladybug->writeDepth() . '[0] => ' . implode(self::CHAR_SEPARATOR, $column_names) . Dumper::CHAR_NEWLINE . $result;
        return $result_with_names;
    }
}