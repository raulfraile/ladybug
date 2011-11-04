Ladybug: Simple and Extensible PHP Dumper
=========================================

Ladybug provides an easy and extensible var_dump/print_r replacement. For example,
with this library, the following is possible:

``` php
<?php
    $var1 = NULL;
    $var2 = 15;
    $var3 = 15.5;
    $var4 = 'hello world!';
    $var5 = false;

    ladybug_dump($var1, $var2, $var3, $var4, $var5);
```

As a result:

<pre><strong><em>NULL</em></strong>
<strong><em>int</em></strong> <span style="color:#800">15</span>
<strong><em>float</em></strong> <span style="color:#800">15.5</span>
<strong><em>string(12)</em></strong> <span style="color:#080">"hello world!"</span>
<strong><em>bool</em></strong> <span style="color:#008">FALSE</span>
</pre>

It is possible to dump any variable, including arrays, objects and resources:

``` php
<?php
    $var = array(1, 2, 3);
    ladybug_dump($var)
```

<pre><strong><em>array</em></strong> [
    [0] => <strong><em>int</em></strong> <span style="color:#800">1</span>
    [1] => <strong><em>int</em></strong> <span style="color:#800">2</span>
    [2] => <strong><em>int</em></strong> <span style="color:#800">3</span>
]</pre>

There are more examples in `examples` directory.

## Instalation

As easy as include the library and use the provided helpers:

``` php
<?php
require_once 'Ladybug.php';

ladybug_dump($var1);
```

## Helpers

The are 3 helpers:

`ladybug_dump($var1[, $var2[, ...]])`: Dumps one or more variables

`ladybug_dump_die($var1[, $var2[, ...]])`: Dumps one or more variables and 
terminates the current script

`ladybug_dump_return($var1[, $var2[, ...]])`: Dumps one or more variables and
returns the string

## Extensible

The library is easily extensible by adding new classes in `lib/objects` and
`lib/resources` directories. These new classes will have to extend from 
`LadybugExtension` class.

For example, there is already an extension to dump the rows of a mysql resultset,
in `lib/resources/mysql_result.php`, so once is defined, Ladybug will be able to
find it and use its `dump` method:

``` php
<?php
    $connection = mysql_connect('localhost', 'dbuser', 'dbpassword');
    mysql_select_db('dbname', $connection);
    $result = mysql_query('SELECT * FROM user', $connection);

    ladybug_dump($result);
```

Will dump:

<pre><strong><em>resource(mysql result)</em></strong> [
    [0] => id | username
    [1] => 1  | raulfraile
    [2] => 2  | ladybug
]</pre>
