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

namespace Ladybug\Inspector\Resource;

use Ladybug\Dumper;
use Ladybug\Inspector\AbstractInspector;
use Ladybug\Type;

class MysqlResult extends AbstractInspector
{

    public function getData($var)
    {
        $headers = array();
        $rows = array();
        $first = true;
        while ($row = mysql_fetch_assoc($var)) {

            $rowData = array();
            foreach ($row as $k => $v) {
                if ($first) {
                    $headers[] = $k;
                }
                $rowData[] = $v;
            }

            $rows[] = $rowData;
            $first = false;
        }

        /** @var $table Type\Extended\TableType */
        $table = $this->extendedTypeFactory->factory('table', $this->level);

        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->setTitle('MySQL result');

        return $table;
    }
}
