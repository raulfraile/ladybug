<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Type\Exception\InvalidVariableTypeException;

/**
 * StringType is an abstraction of a primitive variable of type 'string'
 */
class StringType extends AbstractType
{
    const TYPE_ID = 'string';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
    }

    /**
     * @inheritdoc
     */
    public function load($var, $level = 1)
    {
        if (!is_string($var)) {
            throw new InvalidVariableTypeException();
        }

        parent::load($var, $level);

        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->_getEncodingForHtmlentities());
    }

    /**
     * @inheritdoc
     */
    public function getInlineValue()
    {
        return sprintf('"%s"', $this->value);
    }

}
