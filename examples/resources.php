<?php

require_once __DIR__.'/../vendor/autoload.php';

$file = fopen(__DIR__ . '/../composer.json', 'r');
$file = fopen(__DIR__ . '/../vendor/autoload.php', 'r');

$ladybug = new \Ladybug\Dumper();
echo $ladybug->dump($file);
