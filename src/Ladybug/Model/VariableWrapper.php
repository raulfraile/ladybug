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

    /**
     * Gets the variable id.
     *
     * @return string Variable id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the variable type.
     *
     * @return int Variable type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets variable.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

}
