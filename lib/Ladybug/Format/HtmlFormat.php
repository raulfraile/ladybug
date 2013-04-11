<?php


namespace Ladybug\Format;

class HtmlFormat implements FormatInterface
{

    const FORMAT_NAME = 'html';

    public function getName()
    {
        return self::FORMAT_NAME;
    }

}
