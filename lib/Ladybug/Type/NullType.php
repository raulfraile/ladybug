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

class NullType extends BaseType
{

    const TYPE_ID = 'null';

    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
    }

    public function getValue()
    {
        return null;
    }

    public function getFormattedValue()
    {
        return 'null';
    }
}
