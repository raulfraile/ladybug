<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Ladybug\Model;

/**
 * Wraps variables to be passed to inspectors and metadatas
 */
class VariableWrapper
{

    const TYPE_CLASS = 0;
    const TYPE_RESOURCE = 1;

    /** @var int $type */
    protected $type;

    /** @var string $id */
    protected $id;

    /** @var mixed $data */
    protected $data;

    /**
     * Constructor.
     * @param string $id
     * @param mixed  $data
     * @param int    $type
     */
    public function __construct($id, $data, $type = self::TYPE_CLASS)
    {
        $this->id = $id;
        $this->data = $data;
        $this->type = $type;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}
