<?php

require_once __DIR__.'/../vendor/autoload.php';

$var1 = 'hello world!';

ladybug_dump_die($var1); // or ldd($var1)

echo 'This code is unreachable!';
