<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/NullType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;

class NullType extends BaseType
{

    const TYPE_ID = 'null';

    public function __construct($level, $container, $key = null)
    {
        parent::__construct(self::TYPE_ID, null, $level, $container, $key);
    }

    public function getValue()
    {
        return null;
    }

    public function getName()
    {
        return 'null';
    }
}
