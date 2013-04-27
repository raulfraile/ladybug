<?php

namespace Ladybug\Theme;

use Ladybug\Format\FormatInterface;

interface ThemeInterface
{
    public function getName();

    public function getParent();

    public function getFormats();

    public function supportsFormat(FormatInterface $format);
}
