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
        $result = array();
        $i = 1;
        $columnNames = array();

        while ($row = mysql_fetch_assoc($var)) {

            $values = array();
            foreach ($row as $k => $v) {
                if ($i == 1) $columnNames[] = $k;
                $values[] = $v;
            }

            $result[$i] = $row;

            $i++;
        }

        $table = new Type\Extended\TableType();
        $table->load($result);
        $table->setHeader($columnNames);

        $collection = Type\Extended\CollectionType::create(array(
            $table
        ));

        $collection->setTitle('MySQL result');

        return $collection;
    }
}
