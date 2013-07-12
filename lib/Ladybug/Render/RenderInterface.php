<?php

namespace Ladybug\Render;

interface RenderInterface
{

    const FORMAT_HTML = 'html';
    const FORMAT_CONSOLE = 'console';
    const FORMAT_TEXT = 'text';

    public function getFormat();

    public function render(array $nodes, array $extraData = array());

    public function setTheme(\Ladybug\Theme\ThemeInterface $theme);

    public function setFormat($format);
}
