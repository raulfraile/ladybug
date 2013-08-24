<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class CollectionType extends AbstractType implements \Countable
{

    const TYPE_ID = 'collection';

    /**
     *
     * @var array
     */
    protected $items;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = array();
    }

    /**
     * Loads collection values from the given array
     * @param array $data
     * @param bool $useKeys
     */
    public function loadFromArray(array $data, $useKeys = true)
    {
        $this->items = array();

        foreach ($data as $key => $item) {
            $this->items[] = $item;
        }
    }

    /**
     * Adds a new value to the collection.
     * @param mixed $value
     */
    public function add($value)
    {
        $this->items[] = $value;
    }

    /**
     * Counts elements of the collection
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Sets level
     * @param int $level
     */
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

}
