<?php

require_once __DIR__.'/../lib/Ladybug.php';

$var1 = 'hello world!';

ladybug_dump_die($var1);

echo 'This code is unreachable!';
