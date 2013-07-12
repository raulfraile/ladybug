<?php

// helpers

function getLadybug()
{
    global $ladybug;

    if (is_null($ladybug)) {
        $ladybug = new \Ladybug\Dumper();
    }

    return $ladybug;
}

function ladybug_set_theme($theme)
{
    $ladybug = getLadybug();
    $ladybug->setTheme($theme);
}

function ladybug_set_format($format)
{
    $ladybug = getLadybug();
    $ladybug->setFormat($format);
}

function ladybug_dump(/*$var1 [, $var2...$varN]*/)
{
    $ladybug = getLadybug();
    echo call_user_func_array(array($ladybug,'dump'), func_get_args());
}

function ladybug_dump_die(/*$var1 [, $var2...$varN]*/)
{
    $ladybug = getLadybug();
    echo call_user_func_array(array($ladybug,'dump'), func_get_args());
    die();
}

// Shortcuts
if (!function_exists('ld')) {
    function ld(/*$var1 [, $var2...$varN]*/)
    {
        call_user_func_array('ladybug_dump', func_get_args());
    }
}

if (!function_exists('ldd')) {
    function ldd(/*$var1 [, $var2...$varN]*/)
    {
        call_user_func_array('ladybug_dump_die', func_get_args());
    }
}
