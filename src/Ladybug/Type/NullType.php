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
 * Null is an abstraction of a primitive variable of type 'null'
 */
class NullType extends AbstractType
{
    const TYPE_ID = 'null';

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
    public function getValue()
    {
        return null;
    }

    public function getFormattedValue()
    {
        return 'null';
    }

    /**
     * @inheritdoc
     */
    public function load($var, $level = 1)
    {
        if (!is_null($var)) {
            throw new InvalidVariableTypeException();
        }

        parent::load($var, $level);
    }

    public function getInlineValue()
    {
        return 'null';
    }
}
