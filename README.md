Ladybug: PHP 5.3+ Extensible Dumper
=========================================

[![Build Status](https://secure.travis-ci.org/raulfraile/ladybug.png)](http://travis-ci.org/raulfraile/ladybug)
[![Latest Stable Version](https://poser.pugx.org/raulfraile/ladybug/v/stable.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Total Downloads](https://poser.pugx.org/raulfraile/ladybug/downloads.png)](https://packagist.org/packages/raulfraile/ladybug)
[![Latest Unstable Version](https://poser.pugx.org/raulfraile/ladybug/v/unstable.png)](https://packagist.org/packages/raulfraile/ladybug)

Ladybug provides an easy and extensible `var_dump`/`print_r` replacement for PHP 5.3+
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

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/simple_variables_modern.png" />

It is also possible to dump arrays, objects and resources:

``` php
<?php
$var = new Foo();
ladybug_dump($var)
```

<img style="border:1px solid #ccc; padding:1px" src="https://github.com/raulfraile/ladybug/raw/master/doc/images/object_modern.png" />

## Themes

There are 3 built-in themes: `base`, `classic` and `modern`. If you want to add your own themes, see the [extending section](https://github.com/raulfraile/ladybug/blob/master/doc/extending.md)

## Documentation

1. [Usage](https://github.com/raulfraile/ladybug/blob/master/doc/usage.md).
2. [Instalation](https://github.com/raulfraile/ladybug/blob/master/doc/installation.md).
3. [Examples](https://github.com/raulfraile/ladybug/blob/master/doc/examples.md).
4. [Extending](https://github.com/raulfraile/ladybug/blob/master/doc/extending.md).
5. [Reference](https://github.com/raulfraile/ladybug/blob/master/doc/reference.md).

## Support for frameworks

* Symfony2 [LadybugBundle](https://github.com/raulfraile/LadybugBundle).

## Credits

* Raul Fraile ([@raulfraile](https://twitter.com/raulfraile)
* [All contributors](https://github.com/raulfraile/ladybug/contributors)

## License

Ladybug is released under the MIT License. See the bundled LICENSE file for details.