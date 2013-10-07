<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Theme;

/**
 * ThemeResolver selects a theme for a given format.
 *
 * Each theme determines whether it can load a format.
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class ThemeResolver implements \Countable
{

    /** @var ThemeInterface[] An array of ThemeInterface objects */
    protected $themes;

    protected $default = null;

    /**
     * Constructor.
     *
     * @param ThemeInterface[] $themes An array of themes
     */
    public function __construct(array $themes = array())
    {
        $this->themes = $themes;
    }

    /**
     * Adds a theme.
     *
     * @param ThemeInterface $theme A ThemeInterface instance
     * @param $key
     */
    public function addTheme(ThemeInterface $theme, $key, $default = false)
    {
        $this->themes[$key] = $theme;

        if ($default) {
            $this->default = $key;
        }

        return true;
    }

    /**
     * Returns a theme able to render in the given format.
     * @param string $format Format
     *
     * @return ThemeInterface|bool A ThemeInterface instance
     */
    public function resolve($format)
    {
        foreach ($this->themes as $theme) {
            if ($this->supportsFormat($theme, $format)) {
                return $theme;
            }
        }

        return false;
    }

    public function getTheme($key, $format)
    {
        if (!array_key_exists('theme_' . $key, $this->themes)) {
            return $this->getDefaultTheme();
        }

        /** @var $theme ThemeInterface */
        $theme = $this->themes['theme_' . $key];

        while (!is_null($theme)) {

            if ($this->supportsFormat($theme, $format)) {
                return $theme;
            }

            $parent = $theme->getParent();

            $theme = is_null($parent) ? null : $this->themes['theme_'.strtolower($parent)];

        }

        return false;
    }

    protected function supportsFormat(ThemeInterface $theme, $format)
    {
        return in_array($format, $theme->getFormats());
    }

    /**
     * Gets the default theme.
     *
     * @return ThemeInterface
     */
    protected function getDefaultTheme()
    {
        if (!is_null($this->default) && array_key_exists($this->default, $this->themes)) {
            return $this->themes[$this->default];
        }

        return false;
    }

    /**
     * Count number of themes.
     *
     * @return int Number of registered themes
     */
    public function count()
    {
        return count($this->themes);
    }


}
