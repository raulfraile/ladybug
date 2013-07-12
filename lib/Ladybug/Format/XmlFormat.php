<?php

namespace Ladybug\Format;

class XmlFormat implements FormatInterface
{

    const FORMAT_NAME = 'xml';

    public function getName()
    {
        return self::FORMAT_NAME;
    }

}
