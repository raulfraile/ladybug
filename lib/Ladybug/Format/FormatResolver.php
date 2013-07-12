<?php

namespace Ladybug\Format;

use Ladybug\Format\FormatInterface;

class FormatResolver
{

    /** @var array $formats */
    protected $formats;

    public function __construct($defaultFormat = null)
    {
        $this->formats = array();
    }

    /**
     * Registers a new environment
     *
     * When resolving, this environment is preferred over previously registered ones.
     *
     * @param ThemeInterface $theme
     */
    public function register(FormatInterface $format, $key)
    {
        $this->formats[$key] = $format;
    }

    /**
     * Resolve theme
     *
     * @return ThemeInterface
     */
    public function getFormat($key)
    {
        return $this->formats['format_'.$key];
    }
}
