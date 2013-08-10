<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/StringType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Type\Exception\InvalidVariableTypeException;

class StringType extends AbstractType
{
    const TYPE_ID = 'string';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
    }

    public function load($var, $level = 1)
    {
        if (!is_string($var)) {
            throw new InvalidVariableTypeException();
        }

        parent::load($var, $level);

        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->_getEncodingForHtmlentities());
    }

    public function getInlineValue()
    {
        return sprintf('"%s"', $this->value);
    }


}
