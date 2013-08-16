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

use Ladybug\Inspector\AbstractInspector;
use Ladybug\Inspector\InspectorInterface;
use Ladybug\Type;

class MysqlResult extends AbstractInspector
{
    public function accept($var, $type = InspectorInterface::TYPE_CLASS)
    {
        return InspectorInterface::TYPE_RESOURCE == $type && is_resource($var) && 'mysql result' === get_resource_type($var);
    }

    public function getData($var, $type = InspectorInterface::TYPE_CLASS)
    {
        if (!$this->accept($var, $type)) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

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
        $table->setTitle('MySQL resultset');

        return $table;
    }
}
