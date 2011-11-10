<?php
require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();

$var1 = array();

$var1[0] = array(
    'name' => 'Raul',
    'age' => 29
);
        
$var1[1] = array(
    'name' => 'John',
    'age' => 27
);

ladybug_dump($var1);
