# Usage

You need to `require` the Composer's autoload file. Once loaded, you will be able to use
the helpers as well as create `Dumper` instancies:

``` php
<?php
require 'vendor/autoload.php';

$var = 1;

ladybug_dump($var); // or ld($var);
ladybug_dump_die($var); // or ldd($var);
```

Creating an instance of the `Dumper`:

``` php
<?php
require 'vendor/autoload.php';

$dumper = new \Ladybug\Dumper();
echo $dumper->dump($var);
```

## Helpers

The library provides 2 helpers:

`ladybug_dump($var1[, $var2[, ...]])`: Dumps one or more variables

`ladybug_dump_die($var1[, $var2[, ...]])`: Dumps one or more variables and
terminates the current script

There are also some shortcuts in case you are not using this function names:

`ld($var1[, $var2[, ...]])`: shortcut for ladybug_dump

`ldd($var1[, $var2[, ...]])`: shortcut for ladybug_dump_die
