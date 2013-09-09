<?php

namespace Ladybug\Environment;

use Ladybug\Format;

class CliEnvironment extends AbstractEnvironment
{

    protected $sapiName;

    public function __construct($sapiName = null)
    {
        $this->sapiName = is_null($sapiName) ? php_sapi_name() : $sapiName;
    }

    public function getName()
    {
        return 'Cli';
    }

    public function supports()
    {
        return 'cli' === $this->sapiName;
    }

    public function getDefaultFormat()
    {
        return Format\ConsoleFormat::FORMAT_NAME;
    }
}
