<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$img = imagecreatefrompng(__DIR__ . '/images/apilinks_example.png');

$dumper = new \Ladybug\Dumper();

echo $dumper->dump($img);
