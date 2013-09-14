# Examples

Ladybug allows dumpling any variable, including arrays, objects and resources. Just provide
a variable and Ladybug will take care of the rest:

## Simple variables

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

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/simple_variables_modern.png" />

## Arrays

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

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/array_modern.png" />

## Objects

``` php
<?php
$var = new Foo();
ladybug_dump($var)
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/object_modern.png" />

## Resources

``` php
<?php
$fh = fopen('test.txt', 'r');
ladybug_dump($fh)
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/resource_modern.png" />

## Other formats

Ladybug is able to detect being used (e.g. browser, CLI or an ajax request) and chooses the right format:

* Browser -> Html
* CLI -> Console
* Ajax -> Text

### CLI (Command-line interface)

``` bash
$ php examples/array.php
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/array_cli_modern.png" />

### Text

```
array(2)
    [0]: array(2)
        [name]: string(4) "Raul"
        [age]: int 29
    [1]: array(2)
        [name]: string(4) "John"
        [age]: int 27
```

### Serializable

Variable dumps can be exported to some other formats, like XML, JSON or YAML, but for this,
Ladybug needs other packages to do the job: jms/serializer` (for XML and JSON) and `symfony/yaml` (for YAML):

``` php
<?php
$var = 1;

$dumper = new \Ladybug\Dumper();
$dumper->setFormat('json');
$json = $dumper->dump($var);
```

## Extended objects/resources

Ladybug allows extending any object or resource to display richer information.
For example, the `ladybug-plugin-extra` package provides built-in inspectors for
MySQL resultsets or GD images:

``` php
<?php
    $connection = mysql_connect('localhost', 'dbuser', 'dbpassword');
    mysql_select_db('dbname', $connection);
    $result = mysql_query('SELECT * FROM user', $connection);

    ladybug_dump($result);
```
<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/db_modern.png" />

``` php
<?php
    $img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');
    ladybug_dump($img);
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/gd_modern.png" />

New inspectors can be added easily, see the [extending](https://github.com/raulfraile/ladybug/blob/master/doc/extending.md) section for more info.

### Object metadata

Ladybug also detects automatically some classes to display an icon and a link to the documentation. For example, provides built-in
support for PHP objects and Symfony2 classes:

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/metadata_php_modern.png" />
<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/metadata_symfony_modern.png" />

## More examples

There are lots of examples in the [/examples directory](https://github.com/raulfraile/ladybug/blob/master/examples).


***

Next section: [Usage](https://github.com/raulfraile/ladybug/blob/master/doc/usage.md).