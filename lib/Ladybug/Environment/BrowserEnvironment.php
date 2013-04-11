<?php


namespace Ladybug\Environment;

use Ladybug\Format;

class BrowserEnvironment extends BaseEnvironment
{

    public function getName()
    {
        return 'Browser';
    }

    public function isActive()
    {
        return true;
    }

    function getDefaultFormat()
    {
        return Format\HtmlFormat::FORMAT_NAME;
    }
}
