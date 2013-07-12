<?php

namespace Ladybug\Theme;

interface CliThemeInterface extends ThemeInterface
{
    public function getCliColors();

    public function getCliTags();
}
