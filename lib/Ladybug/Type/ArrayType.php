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

class ArrayType extends BaseType
{

    const TYPE_ID = 'array';

    protected $maxLevel;

    /** @var FactoryType $factory */
    protected $factory;

    public function __construct($maxLevel, FactoryType $factory)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->level = 0;
        $this->maxLevel = $maxLevel;
        $this->factory = $factory;
    }

    public function load($var)
    {
        $this->length = count($var);
        if ($this->level < $this->maxLevel) {
            foreach ($var as $k=>$v) {
                $arrayItem = new Item($k, $this->factory->factory($v, $this->level));

                $this->add($arrayItem);
            }
        }


    }

    public function add(Item $var)
    {
        $this->value[] = $var;
    }

    public function getFormattedValue()
    {
        return 'array';
    }
}
