<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * AbstractPlugin class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class TableType extends BaseType
{

    const TYPE_ID = 'table';

    /** @var array $headers */
    protected $headers;

    /** @var array $rows */
    protected $rows;

    /** @var array $columnMaxWidth */
    protected $columnMaxWidth;

    /** @var string $title */
    protected $title;

    public function __construct()
    {
        $this->headers = array();
        $this->rows = array();
        $this->columnMaxWidth = array();
        $this->title = '';
    }

    public function setHeaders($header)
    {
        $this->headers = array_values($header);
        $this->updateColumnMaxWidth();
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function load($var, $key = null)
    {
        $this->data = $var;
        $this->key = $key;

    }

    public static function create($var, $key = null)
    {
        $object = new static();
        $object->load($var, $key);

        return $object;
    }

    public function getColumnsNumber()
    {
        return count($this->headers);
    }

    public function getRowsNumber()
    {
        return count($this->rows);
    }

    public function getField($row, $column, $padded = false)
    {
        $value = $this->rows[$row][$column];

        if ($padded) {
            $value = str_pad($value, $this->columnMaxWidth[$row][$column]);
        }

        return $value;
    }

    public function getColumnMaxWidth()
    {
        return $this->columnMaxWidth;
    }

    /**
     * @param array $rows
     */
    public function setRows(array $rows)
    {
        $this->rows = $rows;
        $this->updateColumnMaxWidth();
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    protected function updateColumnMaxWidth()
    {
        $this->columnMaxWidth = array();

        $i = 0;
        foreach ($this->headers as $header) {
            $this->columnMaxWidth[$i] = strlen($header);
            $i++;
        }

        foreach ($this->rows as $row) {
            $i = 0;
            foreach ($row as $column) {
                $this->columnMaxWidth[$i] = max($this->columnMaxWidth[$i], strlen($column));
                $i++;
            }
        }
    }

    public function getMaxWidthByColumn($columnNumber)
    {
        return $this->columnMaxWidth[$columnNumber];
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


}
