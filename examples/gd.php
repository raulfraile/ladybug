<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');

ladybug_dump($img);
