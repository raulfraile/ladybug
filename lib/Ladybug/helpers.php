<?php

// helpers

/**
 * return Ladybug\Dumper
 */
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

function ladybug_set_option($name, $value)
{
    $ladybug = getLadybug();
    $ladybug->setOption($name, $value);
}

function ladybug_set_options(array $options)
{
    foreach ($options as $name => $value) {
        ladybug_set_option($name, $value);
    }
}

function ladybug_register_plugin($plugin)
{
    $ladybug = getLadybug();
    $ladybug->registerPlugin($plugin);
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
    die(1);
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
