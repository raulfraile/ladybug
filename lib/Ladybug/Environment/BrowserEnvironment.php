<?php


namespace Ladybug\Environment;

class BrowserEnvironment implements EnvironmentInterface
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
        return 'Html';
    }
}
