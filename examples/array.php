<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$var1 = array();

$var1[0] = array(
    'name' => 'Raul',
    'url' => 'http://twitter.com/raulfraile',
    'stats' => array(
        array(1,2,3),
        array(3,4)
    )
);

$var1[1] = array(
    'name' => 'John',
    'age' => 27
);

$var1[2] = array(
    '<<name>>' => '<<Ladybug>>',
    '<<age>>' => 2
);

//$var1[3] = new stdClass();
//$var1[4] = fopen(__DIR__.'/images/ladybug.png', 'r');

$dumper = new \Ladybug\Dumper();
//$dumper->setTheme('base');
//$dumper->setFormat(\Ladybug\Format\HtmlFormat::FORMAT_NAME);
echo $dumper->dump($var1);
