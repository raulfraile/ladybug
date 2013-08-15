<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

$connection = mysql_connect('localhost', 'root', '249981534');
mysql_select_db('books', $connection);
$result = mysql_query('SELECT id, title, isbn FROM Book', $connection);

ladybug_dump($connection, $result);
