<?php

require_once __DIR__.'/../vendor/autoload.php';

$file = fopen(__DIR__ . '/../composer.json', 'rb');

$ladybug = new \Ladybug\Dumper();
echo $ladybug->dump($file);
