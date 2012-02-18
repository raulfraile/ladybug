<?php

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Autoloader::register();

$connection = mysql_connect('localhost', 'dbuser', 'dbpass');
mysql_select_db('dbname', $connection);
$result = mysql_query('SELECT * FROM user', $connection);

ladybug_dump($connection, $result);