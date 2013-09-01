<?php

namespace Ladybug\Environment;

use Ladybug\Format;

class BrowserEnvironment extends AbstractEnvironment
{

    public function getName()
    {
        return 'Browser';
    }

    public function isActive()
    {
        return true;
    }

    public function getDefaultFormat()
    {
        return Format\HtmlFormat::FORMAT_NAME;
    }
}
