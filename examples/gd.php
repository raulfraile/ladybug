<?php

require_once __DIR__.'/../vendor/autoload.php';

$img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');

$dumper = new \Ladybug\Dumper();

echo $dumper->dump($img);
