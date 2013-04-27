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

use Ladybug\Options;

class StringType extends BaseType
{

    const TYPE_ID = 'string';

    /**
     * Constructor
     * @param string  $var
     * @param int     $level
     * @param Options $options
     */
    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;

    }

    public function load($var, $key = null)
    {
        parent::load($var, $key);

        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->_getEncodingForHtmlentities());

    }
}
