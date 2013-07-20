Installation
============

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

After running the install command, you must see a new vendor directory that must contain the Ladybug code.