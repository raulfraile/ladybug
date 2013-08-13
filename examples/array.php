<?php

require_once __DIR__.'/../vendor/autoload.php';

$var = array(
    array(
        'name' => 'Raul',
        'age' => 29,
        'languages' => array(
            'Spanish',
            'English'
        ),array(array(array(array(array(array(array(array(array(1,2,3)))))))))
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