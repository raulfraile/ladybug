<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Object;

interface VisibilityInterface
{
    const VISIBILITY_PUBLIC = 0;
    const VISIBILITY_PROTECTED = 1;
    const VISIBILITY_PRIVATE = 2;

    /**
     * Gets visibility.
     *
     * @return int
     */
    public function getVisibility();

    /**
     * Sets visibility.
     * @param int $visibility
     */
    public function setVisibility($visibility);
}
