<?php


namespace Ladybug\Format;

class TextFormat implements FormatInterface
{

    const FORMAT_NAME = 'text';

    public function getName()
    {
        return self::FORMAT_NAME;
    }

}
