# Installation

The recommended way to install Geocoder is through [Composer](http://packagist.org/about-composer). Just create a composer.json file for your project:

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

After running the install command, you must see a new vendor directory that must contain the Ladybug code.
Once added the autoloader you will have access to the library:

``` php
<?php

require 'vendor/autoload.php';
```

[![Latest Stable Version](https://poser.pugx.org/raulfraile/ladybug/v/stable.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Latest Unstable Version](https://poser.pugx.org/raulfraile/ladybug/v/unstable.png)](https://packagist.org/packages/raulfraile/ladybug)