<?php

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Ladybug\Tests', __DIR__);

if (!class_exists('\\Mockery')) {
    echo "You must install the dev dependencies using:\n";
    echo "    composer install --dev\n";
    exit(1);
}