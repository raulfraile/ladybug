# Usage

You need to `require` the Composer's autoload file. Once loaded, you will be able to use
the helpers as well as create `Dumper` instancies:

``` php
<?php
require 'vendor/autoload.php';

$var = 1;

ladybug_dump($var); // or ld($var);
// ladybug_dump_die($var); // or ldd($var);
```

Creating an instance of the `Dumper`:

``` php
<?php
require 'vendor/autoload.php';

$dumper = new \Ladybug\Dumper();
echo $dumper->dump($var);
```

In both cases the result is the same:

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/int_modern.png" />

## Helpers

The library provides some helpers and shortcuts for easier use:

### Dump variables

`ladybug_dump($var1[, $var2[, ...]])`: Dumps one or more variables

`ladybug_dump_die($var1[, $var2[, ...]])`: Dumps one or more variables and
terminates the current script

`ld($var1[, $var2[, ...]])`: Shortcut for ladybug_dump

`ldd($var1[, $var2[, ...]])`: Shortcut for ladybug_dump_die

### Configuration

`ladybug_set_theme($themeName)`: Set theme (e.g. "classic")

`ladybug_set_format($formatName)`: Set format (e.g. "html")


***

Next section: [Installation](https://github.com/raulfraile/ladybug/blob/master/doc/installation.md).

Previous section: [Examples](https://github.com/raulfraile/ladybug/blob/master/doc/examples.md).
