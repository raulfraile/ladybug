<?php

require_once __DIR__.'/../lib/Ladybug.php';

$img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');

ladybug_dump($img);