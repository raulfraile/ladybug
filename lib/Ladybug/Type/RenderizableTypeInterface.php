<?php

namespace Ladybug\Type;

interface RenderizableTypeInterface
{
    public function getTemplateName();

    /**
     * @abstract
     * @return mixed
     */
    public function isComposed();

    public function getInlineValue();

    public function getLevel();

}
