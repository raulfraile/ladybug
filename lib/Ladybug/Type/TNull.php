<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/TNull variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;

class TNull extends TBase
{

    const TYPE_ID = 'null';

    public function __construct($level, Options $options)
    {
        parent::__construct(self::TYPE_ID, null, $level, $options);
    }

    public function getValue()
    {
        return null;
    }
}
