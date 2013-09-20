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
 * ExtendedTypeInterface is the interface implemented by all type classes
 */
interface ExtendedTypeInterface
{

    /**
     * Gets title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Sets title
     * @param string $title
     *
     * @return bool
     */
    public function setTitle($title);

    /**
     * Sets level
     * @param int $level
     *
     * @return bool
     */
    public function setLevel($level);
}
