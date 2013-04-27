<?php

namespace Ladybug\Render;

interface RenderInterface
{

    const FORMAT_HTML = 'html';
    const FORMAT_CLI = 'cli';
    const FORMAT_TEXT = 'text';

    public function getFormat();

    public function render(array $nodes);
}
