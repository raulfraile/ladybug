<?php


namespace Ladybug\Theme;

use Ladybug\Format\FormatInterface;

interface ThemeInterface
{
    function getName();

    function getParent();

    function getFormats();

    function supportsFormat(FormatInterface $format);
}
