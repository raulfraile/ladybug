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
    public function __construct($var, $level, $container, $key = null)
    {
        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->_getEncodingForHtmlentities());        


        parent::__construct(self::TYPE_ID, $var, $level, $container, $key);
    }

    public function getFormattedValue()
    {

        return $this->value;
    }

    public function export()
    {
        return array(
            'type' => $this->type,
            'value' => $this->value,
            'length' => $this->length,
            'encoding' => $this->encoding
        );
    }

    public function getName()
    {
        return 'string';
    }
}
