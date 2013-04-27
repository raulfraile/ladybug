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
use Ladybug\Extension\Type;

class MysqlResult extends ExtensionBase
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

        $table = new \Ladybug\Extension\Type\TableType();
        $table->load($result);
        $table->setHeader($columnNames);

        $collection = Type\CollectionType::create(array(
            $table
        ));

        $collection->setTitle('MySQL result');

        return $collection;
    }
}
