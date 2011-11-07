<?php
require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug_Autoloader::register();

$file = fopen(__DIR__ . '/../LICENSE', 'r');
ladybug_dump($file);