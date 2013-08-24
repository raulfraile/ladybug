<?php

require_once __DIR__.'/../vendor/autoload.php';

$var = 15;

$dumper = new \Ladybug\Dumper();
$dumper->setFormat(\Ladybug\Format\JsonFormat::FORMAT_NAME);

echo $dumper->dump($var);
