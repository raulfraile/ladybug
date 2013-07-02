<?php

namespace Ladybug\Theme;

use Ladybug\Container;
use Ladybug\Format\FormatInterface;

class ThemeResolver
{

    /** @var array $themes */
    protected $themes = array();

    protected $format;


    public function __construct(Container $container, FormatInterface $format)
    {
        /** @var $theme ThemeInterface */
        var_dump('theme.' . strtolower($container->getParameter('theme')));
        $theme = $container['theme.' . strtolower($container->getParameter('theme'))];
        $this->register($theme);

        while (!is_null($theme->getParent())) {

            /** @var $theme ThemeInterface */
            $theme = $container['theme.' . strtolower($theme->getParent())];
            $this->register($theme);

        }

        $this->format = $format;
    }

    /**
     * Registers a new environment
     *
     * When resolving, this environment is preferred over previously registered ones.
     *
     * @param ThemeInterface $theme
     */
    public function register(ThemeInterface $theme)
    {
        array_push($this->themes, $theme);
    }

    /**
     * Resolve theme
     *
     * @return ThemeInterface
     */
    public function resolve()
    {

        foreach ($this->themes as $item) {
            /** @var ThemeInterface $item */

            if ($item->supportsFormat($this->format)) {
                return $item;
            }
        }

    }
}
