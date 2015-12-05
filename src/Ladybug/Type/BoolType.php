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
 * Bool is an abstraction of a primitive variable of type 'bool'
 */
class BoolType extends AbstractType
{

    const TYPE_ID = 'bool';

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
    public function getFormattedValue()
    {
        return $this->value ? 'true' : 'false';
    }

    /**
     * @inheritdoc
     */
    public function load($var, $level = 1)
    {
        if (!is_bool($var)) {
            throw new InvalidVariableTypeException();
        }

        parent::load($var, $level);
    }

    /**
     * @inheritdoc
     */
    public function getInlineValue()
    {
        return $this->value ? 'true' : 'false';
    }

}
