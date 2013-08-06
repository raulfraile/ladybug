<?php

namespace Ladybug\Type\Extended;

use Ladybug\Type\TypeInterface;

interface ExtendedTypeInterface extends TypeInterface
{
    public function getTitle();

    public function setTitle($title);
}
