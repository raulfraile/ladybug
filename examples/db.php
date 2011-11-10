<?php
require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();


$h = mysql_connect('localhost', 'dbuser', 'dbpass');
mysql_select_db('dbname', $h);
$result = mysql_query('SELECT * FROM user', $h);

ladybug_dump($h, $result);

