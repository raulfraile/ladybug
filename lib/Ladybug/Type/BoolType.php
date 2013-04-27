<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/BoolType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;

class BoolType extends BaseType
{

    const TYPE_ID = 'bool';

    /**
     * Constructor
     *
     * @param string  $var
     * @param mixed   $level
     * @param Options $options
     */
    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
    }

    public function getFormattedValue()
    {
        return $this->value ? 'true' : 'false';
    }

}
