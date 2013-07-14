<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$var = array(
    array(
        'name' => 'Raul',
        'age' => 29,
        'languages' => array(
            'Spanish',
            'English'
        )
    ),
    array(
        'name' => 'John',
        'age' => 27,
        'languages' => array(
            'English'
        )
    )
);

ladybug_dump($var);