<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/TBool variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;

class TBool extends TBase
{

    const TYPE_ID = 'bool';
    const TRUE_REPRESENTATION = 'TRUE';
    const FALSE_REPRESENTATION = 'FALSE';

    /**
     * Constructor
     *
     * @param string  $var
     * @param mixed   $level
     * @param Options $options
     */
    public function __construct($var, $level, Options $options)
    {
        parent::__construct(self::TYPE_ID, $var, $level, $options);
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value ? self::TRUE_REPRESENTATION : self::FALSE_REPRESENTATION;
    }

}
