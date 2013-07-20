Ladybug: PHP 5.3+ Extensible Dumper
=========================================

[![Build Status](https://secure.travis-ci.org/raulfraile/ladybug.png)](http://travis-ci.org/raulfraile/ladybug)
[![Latest Stable Version](https://poser.pugx.org/raulfraile/ladybug/v/stable.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Total Downloads](https://poser.pugx.org/raulfraile/ladybug/downloads.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Latest Unstable Version](https://poser.pugx.org/raulfraile/ladybug/v/unstable.png)](https://packagist.org/packages/raulfraile/ladybug)

Ladybug provides an easy and extensible var_dump/print_r replacement for PHP 5.3+
projects. You can easily dump any PHP variable, object or resource:

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

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/doc/images/simple_variables_modern.png" />

## Examples

It is possible to dump any variable, including arrays, objects and resources:
    
### Dumping an array

``` php
<?php
    $var = array(
        array(
            'name' => 'Raul',
            'age' => 29
        ),
        array(
            'name' => 'John',
            'age' => 27
        )
    );
    
    ladybug_dump($var)
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/doc/images/array_modern.png" />

### Dumping an object

``` php
<?php
    $var = new Foo();
    ladybug_dump($var)
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/doc/images/object_modern.png" />

### Dumping a mysql resultset

``` php
<?php
    $connection = mysql_connect('localhost', 'dbuser', 'dbpassword');
    mysql_select_db('dbname', $connection);
    $result = mysql_query('SELECT * FROM user', $connection);

    ladybug_dump($result);
```
<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/doc/images/db_modern.png" />

### Dumping a GD image

``` php
<?php
    $img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');
    ladybug_dump($img);
```
    
<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/doc/images/gd_modern.png" />
    
### CLI (Command-line interface) support

``` bash
$ php examples/array.php
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/Ladybug/raw/master/doc/images/array_cli_modern.png" />

There are more examples in `examples` directory.

1. [Instalation](https://github.com/raulfraile/ladybug/doc/installation.rst).

## Installation using Composer

[Composer](http://packagist.org/about-composer) is a project dependency manager for PHP. You have to list
your dependencies in a `composer.json` file:

``` json
{
    "require": {
        "raulfraile/ladybug": "1.0.0-alpha1"
    }
}
```
To actually install Ladybug in your project, download the composer binary and run it:

``` bash
wget http://getcomposer.org/composer.phar
# or
curl -O http://getcomposer.org/composer.phar

php composer.phar install
```

After running the install command, you must see a new vendor directory that must contain the Ladybug code. Then,
you must load ladybug helpers:

``` php
<?php
require_once __DIR__ . '/vendor/autoload.php';

$var1 = 1;
ladybug_dump($var1);
```

## Helpers

The are 2 helpers:

`ladybug_dump($var1[, $var2[, ...]])`: Dumps one or more variables

`ladybug_dump_die($var1[, $var2[, ...]])`: Dumps one or more variables and 
terminates the current script
        
There are also some shortcuts in case you are not using this function names:
        
`ld($var1[, $var2[, ...]])`: shortcut for ladybug_dump
        
`ldd($var1[, $var2[, ...]])`: shortcut for ladybug_dump_die

## Customizable

to-do
        
## Extensible

to-do
        
## Symfony2 users
        
Take a look at [LadybugBundle](https://github.com/raulfraile/LadybugBundle).
