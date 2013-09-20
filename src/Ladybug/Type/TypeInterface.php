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

/**
 * TypeInterface is the interface implemented by all type classes
 */
interface TypeInterface
{

    /**
     * Loads the variable into the type object.
     * @param mixed $var   Variable
     * @param int   $level Level
     *
     * @return bool
     */
    public function load($var, $level = 1);

    /**
     * Sets the level.
     * @param int $level Level
     *
     * @return bool
     */
    public function setLevel($level);

    /**
     * Gets the level.
     *
     * @return int Level
     */
    public function getLevel();
}
