<?php

namespace Ladybug\Type;

interface TypeInterface
{
    public function getTemplateName();

    public function load($var);

    //public function getParameters();
}
