Ladybug: Simple and Extensible PHP Dumper
=========================================

Ladybug provides an easy and extensible var_dump/print_r replacement for PHP 5.3+
projects. For example, with this library, the following is possible:

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

## Examples

It is possible to dump any variable, including arrays, objects and resources:
    
### Dumping an array

``` php
<?php
    $var = array(1, 2, 3);
    ladybug_dump($var)
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/examples/images/array_example.png" />

### Dumping an object

``` php
<?php
    $var = new Foo();
    ladybug_dump($var)
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/examples/images/object_example.png" />

### Dumping a mysql resultset

``` php
<?php
    $connection = mysql_connect('localhost', 'dbuser', 'dbpassword');
    mysql_select_db('dbname', $connection);
    $result = mysql_query('SELECT * FROM user', $connection);

    ladybug_dump($result);
```
<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/examples/images/db_example.png" />

### Dumping a GD image

``` php
<?php
    $img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');
    ladybug_dump($img);
```
    
<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/examples/images/gd_example.png" />

There are more examples in `examples` directory.

## Installation

As easy as [download](https://github.com/raulfraile/Ladybug/zipball/master), include the library and use the provided helpers:

``` php
<?php
require_once 'lib/Ladybug/Autoloader.php';
Ladybug_Autoloader::register();

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

The library is easily extensible by adding new classes in `lib/Ladybug/Extension/Object` 
and `lib/Ladybug/Extension/Resource` directories. These new classes will have to
extend from `LadybugExtension` class.

For example, there is already an extension to dump the rows of a mysql resultset,
in `lib/Ladybug/Extension/Resource/MysqlResult.php`, so once is defined, Ladybug
will be able to find it and use its `dump` method.

If you want to add a new dumper for DateTime object, you should 
create a new class in `lib/Ladybug/Extension/Object/Datetime.php`, that will 
extend from `LadybugExtension` and will have to provide a public method called
`dump`.