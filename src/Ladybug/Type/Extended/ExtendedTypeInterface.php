<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

interface ExtendedTypeInterface
{
    public function getTitle();

    public function setTitle($title);

    public function setLevel($level);
}
