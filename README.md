Ladybug: PHP 5.3+ Extensible Dumper
=========================================

[![Build Status](https://secure.travis-ci.org/raulfraile/ladybug.png)](http://travis-ci.org/raulfraile/ladybug)
[![Latest Stable Version](https://poser.pugx.org/raulfraile/ladybug/v/stable.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Total Downloads](https://poser.pugx.org/raulfraile/ladybug/downloads.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Latest Unstable Version](https://poser.pugx.org/raulfraile/ladybug/v/unstable.png)](https://packagist.org/packages/raulfraile/ladybug)

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/raulfraile/ladybug/badges/quality-score.png?s=2e0e9d4908ef0dee9de47d298275f61971af60e2)](https://scrutinizer-ci.com/g/raulfraile/ladybug/)
[![Code Coverage](https://scrutinizer-ci.com/g/raulfraile/ladybug/badges/coverage.png?s=9de6c73aa0a6a07f7fc02a64d79d16fb60184640)](https://scrutinizer-ci.com/g/raulfraile/ladybug/)

Ladybug provides an easy and extensible `var_dump` / `print_r` replacement for PHP 5.3+
projects. Any PHP variable, object or resource can be dumped to beautiful representation:

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

## Documentation

1. [Examples](https://github.com/raulfraile/ladybug/blob/master/doc/examples.md).
2. [Usage](https://github.com/raulfraile/ladybug/blob/master/doc/usage.md).
3. [Installation](https://github.com/raulfraile/ladybug/blob/master/doc/installation.md).
4. [Extending](https://github.com/raulfraile/ladybug/blob/master/doc/extending.md).
5. [Reference](https://github.com/raulfraile/ladybug/blob/master/doc/reference.md).
6. [Tests](https://github.com/raulfraile/ladybug/blob/master/doc/tests.md).

## Support for other libraries/frameworks

* Symfony 2.x: [LadybugBundle](https://github.com/raulfraile/LadybugBundle).
* Drupal 7x & 8.x: [Ladybug module](https://drupal.org/project/ld).

## Credits

* Raul Fraile ([@raulfraile](https://twitter.com/raulfraile))
* [All contributors](https://github.com/raulfraile/ladybug/contributors)

## License

Ladybug is released under the MIT License. See the bundled LICENSE file for details.
