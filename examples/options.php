<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

ladybug_set('string.html_color', '#ccc');
ladybug_set('int.html_color', '#fff');
ladybug_set('float.html_color', '#f09');
ladybug_set('bool.html_color', '#726');

$var1 = null;
$var2 = 15;
$var3 = 15.5;
$var4 = 'hello world!';
$var5 = false;

ladybug_dump($var1, $var2, $var3, $var4, $var5);
