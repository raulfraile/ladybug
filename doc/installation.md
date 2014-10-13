# Installation

The recommended way to install Ladybug is through [Composer](http://packagist.org/about-composer). 

Download the composer binary:

``` bash
wget http://getcomposer.org/composer.phar
# or
curl -O http://getcomposer.org/composer.phar
```

Now, install Ladybug with Composer:

``` bash
composer.phar require raulfraile/ladybug
```

After running the `require` command, a new directory called 'vendor' will contain the Ladybug code, as well as all
the required dependencies.

Once added the autoloader you will have access to the library:

``` php
<?php

require 'vendor/autoload.php';
```

[![Latest Stable Version](https://poser.pugx.org/raulfraile/ladybug/v/stable.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Latest Unstable Version](https://poser.pugx.org/raulfraile/ladybug/v/unstable.png)](https://packagist.org/packages/raulfraile/ladybug)

## Troubleshooting

### Maximum function nesting level error

The Xdebug extension protects you again infinite recursion limiting the maximum function nesting level. By default,
this value is 100, too low for current projects. If you get this error:

`Fatal error: Maximum function nesting level of '100' reached, aborting!`

Change the `xdebug.max_nesting_level` PHP setting to, at least, 200.

***

Next section: [Extending Ladybug](https://github.com/raulfraile/ladybug/blob/master/doc/extending.md).

Previous section: [Usage](https://github.com/raulfraile/ladybug/blob/master/doc/usage.md).
