<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$zip = new ZipArchive();
$zip->open('zip/example.zip');

ladybug_dump($zip);
