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

use Ladybug\Options;

class ArrayType extends BaseType
{

    const TYPE_ID = 'array';

    public function __construct(array $var, $level, $container)
    {
        parent::__construct(self::TYPE_ID, array(), $level, $container);

        $this->length = count($var);

        if ($this->level < $this->getOption('array.max_nesting_level')) {
            foreach ($var as $k=>$v) {
                $this->add($v, $k);
            }
        }
    }

    public function add($var, $index = null)
    {
        $this->value[$index] = FactoryType::factory($var, $this->level, $this->container);
    }

    public function export()
    {
        $value = array();

        foreach ($this->value as $k=>$v) {
            $value[] = $v->export();
        }

        return array(
            'type' => $this->type,
            'value' => $value,
            'length' => $this->length
        );
    }
}
