Ladybug: Simple and Extensible PHP Dumper
=========================================

Ladybug provides an easy and extensible var_dump/print_r replacement. For example,
with this library, the following is possible:

``` php
<?php
    $var = 'hello world!';
    ladybug_dump($var)
```

As a result:

<pre><strong><em>string(12)</em></strong> <span style="color:#080">"hello world!"</span></pre>

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
`ladybug_dump_return($var1[, $var2[, ...]])`: Returns the value

