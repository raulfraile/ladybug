<?php

namespace Ladybug\Format;

class PhpFormat implements FormatInterface
{

    const FORMAT_NAME = 'php';

    public function getName()
    {
        return self::FORMAT_NAME;
    }

}
