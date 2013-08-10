<?php

namespace Ladybug\Type;

interface TypeInterface
{
    public function load($var, $level = 1);

    public function setLevel($level);
}
