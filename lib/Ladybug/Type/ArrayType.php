<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/ArrayType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Type\ArrayType\Item;
use Ladybug\Type\Exception\InvalidVariableTypeException;

class ArrayType extends AbstractType
{

    const TYPE_ID = 'array';

    protected $maxLevel;

    /** @var FactoryType $factory */
    protected $factory;

    protected $terminal;

    public function __construct($maxLevel, FactoryType $manager)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->level = 0;
        $this->maxLevel = $maxLevel;
        $this->factory = $manager;
        $this->terminal = false;
        $this->value = array();
    }

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

    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;
    }

    public function getTerminal()
    {
        return $this->terminal;
    }

    public function isComposed()
    {
        return true;
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
