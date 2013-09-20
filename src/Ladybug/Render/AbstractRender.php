<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\ThemeResolver;

abstract class AbstractRender implements RenderInterface
{

    /** @var ThemeInterface $theme */
    protected $theme;

    /** @var \Ladybug\Theme\ThemeResolver $themeResolver */
    protected $themeResolver;

    /**
     * Constructor
     * @param \Ladybug\Theme\ThemeResolver $themeResolver
     */
    public function __construct(ThemeResolver $themeResolver)
    {
        $this->themeResolver = $themeResolver;
    }

    /**
     * @param \Ladybug\Theme\ThemeInterface $theme
     */
    public function setTheme(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return \Ladybug\Theme\ThemeInterface
     */
    public function getTheme()
    {
        return $this->theme;
    }

    public function setGlobals(array $globals)
    {

    }

}
