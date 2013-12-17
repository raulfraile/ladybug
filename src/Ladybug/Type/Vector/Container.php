<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Vector;

use Ladybug\Type\Exception\InvalidVariableTypeException;
use Ladybug\Type\AbstractType;
use Ladybug\Type\FactoryType;

/**
 * ArrayType is an abstraction of a PHP native array
 */
class Container extends AbstractType
{

    const TYPE_ID = 'array';

    /** @var int $maxLevel */
    protected $maxLevel;

    /** @var FactoryType $factory */
    protected $factory;

    /** @var bool $terminal */
    protected $terminal;

    /**
     * Constructor.
     * @param int         $maxLevel    Max nesting level for arrays
     * @param FactoryType $factoryType Factory type
     */
    public function __construct($maxLevel, FactoryType $factoryType)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->maxLevel = $maxLevel;
        $this->factory = $factoryType;
        $this->terminal = false;
        $this->value = array();
    }

    /**
     * @inheritdoc
     */
    public function load($var, $level = 1)
    {
        if (!is_array($var)) {
            throw new InvalidVariableTypeException();
        }

        $this->length = count($var);
        $this->level = $level;

        if ($this->level < $this->maxLevel) {
            foreach ($var as $k=>$v) {

                $value = $this->factory->factory($v, $this->level + 1);

                $arrayItem = new Item($k, $value);

                $this->add($arrayItem);
            }
        } else {
            $this->terminal = true;
        }

    }

    public function add(Item $var)
    {
        $this->value[] = $var;
    }

    public function getFormattedValue()
    {
        $values = array();
        foreach ($this->value as $value) {
            /** @var Item $value */
            $values[] = (string) $value->getValue()->getFormattedValue();
        }

        return sprintf('array(%s)', implode(', ', $values));
    }

    /**
     * Checks whether the variable is terminal.
     *
     * @return bool
     */
    public function isTerminal()
    {
        return $this->terminal;
    }

    public function getInlineValue()
    {
        $values = array();
        foreach ($this->value as $value) {
            /** @var Item $value */
            $values[] = (string) $value->getValue()->getInlineValue();
        }

        return sprintf('array(%s)', implode(', ', $values));
    }

    public function setLevel($level)
    {
        parent::setLevel($level);

        foreach ($this->value as $value) {
            /** @var Item $value */
            $value->getValue()->setLevel($level + 1);
        }
    }

}
