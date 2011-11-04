<?php

require_once __DIR__.'/../lib/Ladybug.php';

$file = fopen(__DIR__ . '/../LICENSE', 'r');
ladybug_dump($file);