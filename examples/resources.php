<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$file = fopen(__DIR__ . '/../lib/Ladybug/Config/container.xml', 'r');

$dumper = new \Ladybug\Dumper();
echo $dumper->dump($file);
