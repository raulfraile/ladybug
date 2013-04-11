<?php


namespace Ladybug\Environment;

use Ladybug\Format;

class CliEnvironment extends BaseEnvironment
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
        return Format\ConsoleFormat::FORMAT_NAME;
    }
}
