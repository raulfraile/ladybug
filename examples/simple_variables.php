<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$var1 = null;
$var2 = 15;
$var3 = 15.5;
$var4 = 'Россия';// 'hello world!';
$var5 = false;

//ladybug_dump($var1, $var2, $var3, $var4, $var5);
ladybug_dump($var4);
