<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$file = fopen(__DIR__ . '/../composer.json', 'r');
$file = fopen(__DIR__ . '/../vendor/autoload.php', 'r');

$dumper = new \Ladybug\Dumper();
echo $dumper->dump($file);
