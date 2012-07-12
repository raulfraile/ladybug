<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$var1 = null;
$var2 = 15;
$var3 = 15.5;
$var4 = 'hello world!';
$var5 = false;
$var6 = new \DateTime();
$var7 = array(1, 2, 3, new \DateTime());

echo ladybug_dump_return('json', $var1, $var2, $var3, $var4, $var5, $var6, $var7);
