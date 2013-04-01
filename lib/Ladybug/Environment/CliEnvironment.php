<?php


namespace Ladybug\Environment;

class CliEnvironment implements EnvironmentInterface
{

    public function getName()
    {
        return 'Cli';
    }

    public function isActive()
    {
        return 'cli' === php_sapi_name();
    }

    function getDefaultFormat()
    {
        return 'Console';
    }
}
