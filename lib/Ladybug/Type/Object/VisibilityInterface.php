<?php

namespace Ladybug\Type\Object;

interface VisibilityInterface
{

    const VISIBILITY_PUBLIC = 0;
    const VISIBILITY_PROTECTED = 1;
    const VISIBILITY_PRIVATE = 2;

    public function getVisibility();

    public function setVisibility($visibility);

}
