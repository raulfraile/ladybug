<?php


namespace Ladybug\Theme;

interface ThemeInterface
{
    function getName();

    function getParent();

    function getEnvironments();
}
