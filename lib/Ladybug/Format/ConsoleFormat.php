<?php

namespace Ladybug\Format;

class ConsoleFormat implements FormatInterface
{

    const FORMAT_NAME = 'console';

    public function getName()
    {
        return self::FORMAT_NAME;
    }

}
