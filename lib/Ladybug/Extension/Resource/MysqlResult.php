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
use Ladybug\Extension\ExtensionBase;

class MysqlResult extends ExtensionBase
{
    const CHAR_SEPARATOR = ' | ';
    const MAX_RESULTS = 9;

    public function dump($var)
    {
        $result = array();
        $i = 1;
        $column_names = array();

        while ($row = mysql_fetch_assoc($var)) {

            $values = array();
            foreach ($row as $k => $v) {
                if ($i == 1) $column_names[] = $k;
                $values[] = $v;
            }

            if ($i == 1) $result['c'] = implode(self::CHAR_SEPARATOR, $column_names);

            $result[$i] = implode(self::CHAR_SEPARATOR, $values);

            $i++;

            if ($i > self::MAX_RESULTS) {
                $result['+'] = (mysql_num_rows($var) - self::MAX_RESULTS) . ' more results';
                break;
            }
        }

        // column names
        return $result;
    }
}
