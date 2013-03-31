<?php


namespace Ladybug\Theme;

interface HtmlThemeInterface extends ThemeInterface
{
    function getHtmlCssDependencies();

    function getHtmlJsDependencies();
}
