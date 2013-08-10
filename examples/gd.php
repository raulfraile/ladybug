<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');
$img = imagecreatefrompng('/Users/raulfraile/Sites/servergrove/sgcontrol2/web/images/nav_02.png');
$dumper = new \Ladybug\Dumper();

echo $dumper->dump($img);
