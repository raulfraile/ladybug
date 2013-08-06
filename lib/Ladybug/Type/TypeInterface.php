<?php

namespace Ladybug\Type;

interface TypeInterface
{
    public function getTemplateName();

    public function load($var);

    //public function getParameters();

    /**
     * @abstract
     * @return mixed
     */
    public function isComposed();

    public function getInlineValue();
}
