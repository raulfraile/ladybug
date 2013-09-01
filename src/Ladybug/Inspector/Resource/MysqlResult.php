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
use Ladybug\Inspector\InspectorDataWrapper;
use Ladybug\Type;

class MysqlResult extends AbstractInspector
{
    public function accept(InspectorDataWrapper $data)
    {
        return InspectorInterface::TYPE_RESOURCE == $data->getType() &&
            'mysql result' === $data->getId();
    }

    public function getData(InspectorDataWrapper $data)
    {
        if (!$this->accept($data)) {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        $headers = array();
        $rows = array();
        $first = true;
        while ($row = mysql_fetch_assoc($data->getData())) {

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
