<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$var1 = array();

$var1[0] = array(
    'name' => 'Raul',
    'url' => 'http://twitter.com/raulfraile',
    'stats' => array(
        array(1,2,3),
        array(3,4)
    )
);

$var1[1] = array(
    'name' => 'John',
    'age' => 27
);

$var1[2] = array(
    '<<name>>' => '<<Ladybug>>',
    '<<age>>' => 2
);

ladybug_dump($var1);
