<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Renderer;

use Ladybug\Theme\ThemeInterface;
use Ladybug\Theme\ThemeResolver;

abstract class AbstractRenderer implements RendererInterface
{

    /** @var ThemeInterface $theme */
    protected $theme;

    /** @var \Ladybug\Theme\ThemeResolver $themeResolver */
    protected $themeResolver;

    /** @var array $options */
    protected $options;

    /**
     * Constructor
     * @param \Ladybug\Theme\ThemeResolver $themeResolver
     */
    public function __construct(ThemeResolver $themeResolver, $options = array())
    {
        $this->themeResolver = $themeResolver;
        $this->options = $options;
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
