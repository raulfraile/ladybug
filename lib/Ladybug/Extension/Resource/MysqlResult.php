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

class Ladybug_Extension_Resource_Mysqlresult extends Ladybug_Extension {
    
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
            $result .= implode(self::CHAR_SEPARATOR, $values) . Ladybug_Dumper::CHAR_NEWLINE;
            $i++;
            
            if ($i > self::MAX_RESULTS) {
                $result .= $this->ladybug->writeDepth() . '[...] => '. (mysql_num_rows($var) - self::MAX_RESULTS) . ' more results' . Ladybug_Dumper::CHAR_NEWLINE;
                break;
            }
        }
        
        // column names
        $result_with_names = $this->ladybug->writeDepth() . '[0] => ' . implode(self::CHAR_SEPARATOR, $column_names) . Ladybug_Dumper::CHAR_NEWLINE . $result;
        return $result_with_names;
    }
}