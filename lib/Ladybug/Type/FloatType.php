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

use Ladybug\Options;

class FloatType extends BaseType
{

    const TYPE_ID = 'float';

    public function __construct($var, $level, $container, $key = null)
    {
        parent::__construct(self::TYPE_ID, $var, $level, $container, $key);
    }

    public function getName()
    {
        return 'float';
    }

}
