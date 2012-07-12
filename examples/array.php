<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$var1 = array();

$var1[0] = array(
    'name' => 'Raul',
    'age' => 29,
    'url' => 'http://twitter.com/raulfraile'
);

$var1[1] = array(
    'name' => 'John',
    'age' => 27
);

ladybug_dump($var1);
