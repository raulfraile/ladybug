<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/FloatType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Type\Exception\InvalidVariableTypeException;

class FloatType extends AbstractType
{

    const TYPE_ID = 'float';

    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
    }

    public function load($var)
    {
        if (!is_float($var)) {
            throw new InvalidVariableTypeException();
        }

        parent::load($var);
    }

}
