<?php

namespace Ladybug\Format;

class JsonFormat implements FormatInterface
{

    const FORMAT_NAME = 'json';

    public function getName()
    {
        return 'Json';
    }

}
