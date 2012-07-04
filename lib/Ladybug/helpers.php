<?php

// helpers

function ladybug_set($key, $value)
{
    $ladybug = \Ladybug\Dumper::getInstance();
    $ladybug->setOption($key, $value);
}

function ladybug_dump(/*$var1 [, $var2...$varN]*/)
{
    $ladybug = \Ladybug\Dumper::getInstance();
    echo call_user_func_array(array($ladybug,'dump'), func_get_args());
}

function ladybug_dump_ini($extension = null)
{
    $params = ini_get_all($extension);
    ladybug_dump($params);
}

function ladybug_dump_ext()
{
    $params = get_loaded_extensions();
    ladybug_dump($params);
}

function ladybug_dump_die(/*$var1 [, $var2...$varN]*/)
{
    $ladybug = \Ladybug\Dumper::getInstance();
    echo call_user_func_array(array($ladybug,'dump'), func_get_args());
    die();
}

function ladybug_dump_return(/*$format $var1 [, $var2...$varN]*/)
{
    $ladybug = \Ladybug\Dumper::getInstance();
    $result = call_user_func_array(array($ladybug,'export'), func_get_args());

    return $result;
}

// Shortcuts
if (!function_exists('ld')) {
    function ld(/*$var1 [, $var2...$varN]*/)
    {
        echo call_user_func_array('ladybug_dump', func_get_args());
    }
}

if (!function_exists('ldd')) {
    function ldd(/*$var1 [, $var2...$varN]*/)
    {
        echo call_user_func_array('ladybug_dump_die', func_get_args());
    }
}

if (!function_exists('ldr')) {
    function ldr(/*$format $var1 [, $var2...$varN]*/)
    {
        echo call_user_func_array('ladybug_dump_return', func_get_args());
    }
}
