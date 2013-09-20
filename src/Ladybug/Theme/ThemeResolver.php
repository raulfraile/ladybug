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
class ThemeResolver
{

    /** @var ThemeInterface[] An array of ThemeInterface objects */
    protected $themes;

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
    public function addTheme(ThemeInterface $theme, $key)
    {
        $this->themes[$key] = $theme;
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
        /** @var $theme ThemeInterface */
        $theme = $this->themes['theme_' . $key];

        while (!is_null($theme)) {

            if ($this->supportsFormat($theme, $format)) {
                return $theme;
            }

            $parent = $theme->getParent();
            if (is_null($parent)) {
                return false;
            }

            $theme = $this->themes['theme_'.strtolower($parent)];

        }

    }

    protected function supportsFormat(ThemeInterface $theme, $format)
    {
        return in_array($format, $theme->getFormats());
    }
}
