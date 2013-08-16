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

class CollectionType extends BaseType implements \Countable
{

    const TYPE_ID = 'collection';

    protected $processedData;

    protected $items;

    protected $length;

    public function __construct()
    {
        parent::__construct();

        $this->items = array();
        $this->length = 0;
    }


    public function setProcessedData($processedData)
    {
        $this->processedData = $processedData;
    }

    public function getProcessedData()
    {
        return $this->processedData;
    }

    public function getTemplateName()
    {
        return 'collection';
    }

    public function loadFromArray(array $data, $useKeys = true)
    {
        $this->items = array();

        foreach ($data as $key => $item) {
            $this->items[] = $item;
        }

        $this->length = count($this->items);
    }

    public function load($var, $key = null)
    {
        $this->items = array();

        foreach ($var as $key => $item) {
            $this->items[] = $item;
        }

        $this->length = count($this->items);
    }

    public function add($value)
    {
        $this->items[] = $value;
        $this->length++;
    }

    public static function create(array $var, $key = null)
    {
        $object = new static();
        $object->load($var, $key);

        return $object;
    }

    public function count()
    {
        return count($this->items);
    }

    public function setLevel($level)
    {
        parent::setLevel($level);

        foreach ($this->items as $item) {
            $item->setLevel($level + 1);
        }
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function isComposed()
    {
        return true;
    }

    public function getLength()
    {
        return $this->length;
    }


}
