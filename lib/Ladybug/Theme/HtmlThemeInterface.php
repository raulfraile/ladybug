<?php

namespace Ladybug\Theme;

interface HtmlThemeInterface extends ThemeInterface
{
    public function getHtmlCssDependencies();

    public function getHtmlJsDependencies();
}
