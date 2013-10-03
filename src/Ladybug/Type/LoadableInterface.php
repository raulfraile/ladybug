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

interface LoadableInterface
{

    /**
     * Loads the variable into the type object.
     * @param mixed $var   Variable
     * @param int   $level Level
     *
     * @return bool
     */
    public function load($var, $level = 1);
}
