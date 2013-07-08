<?php

namespace Ladybug\Theme;

use Ladybug\Container;
use Ladybug\Format\FormatInterface;

class ThemeResolver
{

    /** @var array $themes */
    protected $themes;

    protected $defaultTheme;


    public function __construct()
    {
        $this->themes = array();

    }

    /**
     * Registers a new environment
     *
     * When resolving, this environment is preferred over previously registered ones.
     *
     * @param ThemeInterface $theme
     */
    public function register(ThemeInterface $theme, $key)
    {
        $this->themes[$key] = $theme;
    }

    /**
     * Resolve theme
     *
     * @return ThemeInterface
     */
    public function resolve($format)
    {
        foreach ($this->themes as $theme) {
            /** @var $theme ThemeInterface */

            if (in_array($format, $theme->getFormats())) {
                return $theme;
            }
        }

        throw new \Exception('');
    }

    public function getTheme($key, FormatInterface $format)
    {
        /** @var $theme ThemeInterface */
        $theme = $this->themes['theme_'.$key];

        if ($theme->supportsFormat($format)) {
            return $theme;
        }

        while ($theme = $this->themes['theme_'.$theme->getParent()]) {
            if ($theme->supportsFormat($format)) {
                return $theme;
            }
        }

        throw new \Exception('theme not found');

    }
}
