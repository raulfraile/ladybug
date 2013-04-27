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

class ArrayType extends BaseType
{

    const TYPE_ID = 'array';

    protected $maxLevel;

    /** @var FactoryType $factory */
    protected $factory;

    public function __construct($level, $maxLevel, FactoryType $factory)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->level = $level;
        $this->maxLevel = $maxLevel;
        $this->factory = $factory;
    }

    public function load($var, $key = null)
    {
        $this->key = $key;

        $this->length = count($var);
        if ($this->level < $this->maxLevel) {
            foreach ($var as $k=>$v) {
                $this->add($this->factory->factory($v, $k, $this->level + 1));
            }
        }

    }

    public function add($var)
    {
        $this->value[] = $var;
    }

    public function getFormattedValue()
    {
        return 'array';
    }
}
