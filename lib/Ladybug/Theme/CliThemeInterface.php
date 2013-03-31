<?php


namespace Ladybug\Theme;

interface CliThemeInterface extends ThemeInterface
{
    function getCliColors();

    function getCliTags();
}
