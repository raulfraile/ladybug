<?php

namespace Ladybug\Format;

class YamlFormat implements FormatInterface
{

    const FORMAT_NAME = 'yml';

    public function getName()
    {
        return self::FORMAT_NAME;
    }

}
