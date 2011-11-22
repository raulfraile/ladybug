<?php

// helpers

function ladybug_set($key, $value) {
    $ladybug = \Ladybug\Dumper::getInstance();
    $ladybug->setOption($key, $value);
}

function ladybug_dump(/*$var1 [, $var2...$varN]*/) {
    $ladybug = \Ladybug\Dumper::getInstance();
    echo call_user_func_array(array($ladybug,'dump'), func_get_args());  
}

function ladybug_dump_ini($extension = NULL) {
    $params = ini_get_all($extension);
    ladybug_dump($params);
}

function ladybug_dump_ext() {
    $params = get_loaded_extensions();
    ladybug_dump($params);
}

function ladybug_dump_die(/*$var1 [, $var2...$varN]*/) {
    $ladybug = \Ladybug\Dumper::getInstance();
    echo call_user_func_array(array($ladybug,'dump'), func_get_args());  
    die();
}

function ladybug_dump_return(/*$var1 [, $var2...$varN]*/) {
    $ladybug = \Ladybug\Dumper::getInstance();
    $result = call_user_func_array(array($ladybug,'dump'), func_get_args());  

    return $result;
}