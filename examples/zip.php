<?php
require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();

$zip = new ZipArchive();
$zip->open('zip/example.zip');
ladybug_dump($zip);
