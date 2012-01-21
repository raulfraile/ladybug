<?php
require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Autoloader::register();

$img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');

ladybug_dump($img);