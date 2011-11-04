Ladybug: Simple and Extensible PHP Dumper
=========================================

Ladybug provides an easy and extensible var_dump/print_r replacement for PHP
projects. For example, with this library, the following is possible:

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

<pre><strong><em>NULL</em></strong>
<strong><em>int</em></strong> <span style="color:#800">15</span>
<strong><em>float</em></strong> <span style="color:#800">15.5</span>
<strong><em>string(12)</em></strong> <span style="color:#080">"hello world!"</span>
<strong><em>bool</em></strong> <span style="color:#008">FALSE</span>
</pre>

## Examples

### Dumping an array
    
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

### Dumping a GD image

``` php
<?php
    $img = imagecreatefrompng(__DIR__ . '/images/ladybug.png');
    ladybug_dump($img);
```
    
<pre><strong><em>resource(gd)</em></strong> [
    [gd] => [
        [version] => 2.0
        [support] => FreeType[with freetype], T1Lib, GIF, JPEG, PNG, WBMP
    ]
    [width] => 32px
    [height] => 32px
    [colors_palette] => 0
    [true_color] => TRUE
    [image] =>
        <img style="border:1px solid #ccc; padding:1px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAFJklEQVRIib1WXWxURRT+5t67d+9e+rOlbH93WxAoiphCCaKiRnkp0JDqAy9iMCqEhCf8o/JiIgkPECkhJCYEAYOYKCDQGgxoMMSKGCxRhEpoimW727Ls3W233e79vzM+LBT27lbUgOdtznzzfXPOmTMzhDGGh2ncQ2UvIBAKhUKh0H/jKrhWcI0ZYzzPh0KhSCSS9ezdtmmwP/xL97VRcBojAHyElYI2LZhdN2vGurbtE+wcxzmOc38BAJRSAHu2t/E+wnzc9MaG7y5HPR6Pn+cBOI6TsqyZTY+alvXJ7vcdja3ftI1SynFcfkXdAtldxGKxfbs2+/xSVWV5qLZCFL1fdnYTQggh2U0wxp5f0mSYRmQwHruV3Ldrczwer6ys5Dh3zt0CkUjE6/W2rWsN1lXWVAWCtZVFRfJXX58zDMOF/OF8z+pVS6sqpkUHbw3FlPfeXLnjwMl8mFsAwECzuZt4BI9YXR2IJ0f3fvbN0Y4f82Ef7+uMJ4ZbVyzJwjjiGWg282HElbUjhDS/MXXJTxUOIfnovzGesXPPxE/vH16VS+iOoHXDDI7j5lVM7boe/lcCz82sl2WrdUOpy39bIBQK6bou62PhtbPBYcuyxa8dVK4Mxv4h+7zaqi3LFguJb0FRX+xVpRJJkrIH/W4E6XR6fkDYekl/u1Gerfd0ta092zd0oe/GH9Gha0O3LoajLtKF9cE5NZVzgzVPzpr+wqwavv+MRrn2S2qDX+hS0pIkZWF3ayBJ0urHyk8rZFW9uPPpIhAOZQ0oqobkh1QMbwkAjJkAUCICgDEGPQ09hfGbGOkFo2+dHz8SNpsD7POrSV3Xc1IEQNf11seDADqj5k7qAA4SPUj0ZGcj47T9inEmqgvAinpp4xPSNMl9CjqjJoCESSbY4SpyWGUAWVktUJrT8TYlr5zN9Ks0e3d92m/2jjlfvOhzCaysFo5G7bA6+SkSebKuTtg4V6COfa/fcDBi0Xs9cYO5MAA+XCCUeXFyMMef0wcDa2rKfILIc/ktcDHJPvidXU1TAE1+srWRm1PqRjHAdOiIZtcdHCocgaZrXiIyDxHyFBpL0PEsbl5QeIKKRQEAtuXG2AyaxTQ9p59zBDKW7uEcAfxk79AUQgHYtvvCyZpFkTGcjJWjnCOQVk2eWV5wEMjFYal33FPscRaUWkH59hrdAQDRUrPDqOr5ddSTtviGImvhVF23WVqnaWPyImsmBYXEnN2DZYdi8oT/5YD+zsykzMGkAGCbpkqx43r5cUW6A5FereJfrx1JqVBzw8vJxf6zSGlIqOi4uxIAjitSe5/ftmBQGBS2hfY+//FcTIciJVSkNBzomlzgMGOaASWDRbKGXDs17LMt6A50B7aFU8PuJlgka0oGmoHDubepu5rHupFIY7mcailOi/dMtpRkbPNOBCZaSjITUyKHluL0cjmVSONYt4sv7z0A8NF04pFQ5UOZFz+rMk/QOEVtkAAg2g8AwRkA0KvjUkZ2GJ6S1REDMQ2WjndvuNkKCACYX8K9VM7qZYR8KBch8sg2RngAAOrrgNtthaSJiIawihNJ8tsYzacq8GQGAoHkOIZVsqaaJTTUSAh4USRA5JChAKCaMCnGbSgGhnSMWjikkAETgUBAUZT7C0iSFAwG4/F4b9R4pArDOgQOZR6UCvh+FACWShi1MWLBpmAMf8YQ84rBYEXBZBQQAMAYm7hy1xPir0DchkJwWQOAunEwBsaQimPPHdLJ/oOFa/AA7X///D5w+wv9YnRgaef6jQAAAABJRU5ErkJggg==" />
]</pre>

There are more examples in `examples` directory.

## Installation

As easy as download and include the library and use the provided helpers:

``` php
<?php
require_once 'lib/Ladybug.php';

ladybug_dump($var1);
```

## Helpers

The are 3 helpers:

`ladybug_dump($var1[, $var2[, ...]])`: Dumps one or more variables

`ladybug_dump_die($var1[, $var2[, ...]])`: Dumps one or more variables and 
terminates the current script

`ladybug_dump_return($var1[, $var2[, ...]])`: Dumps one or more variables and
returns the string

## Extensible

The library is easily extensible by adding new classes in `lib/objects` and
`lib/resources` directories. These new classes will have to extend from 
`LadybugExtension` class.

For example, there is already an extension to dump the rows of a mysql resultset,
in `lib/resources/mysql_result.php`, so once is defined, Ladybug will be able to
find it and use its `dump` method:

``` php
<?php
    $connection = mysql_connect('localhost', 'dbuser', 'dbpassword');
    mysql_select_db('dbname', $connection);
    $result = mysql_query('SELECT * FROM user', $connection);

    ladybug_dump($result);
```

Will dump:

<pre><strong><em>resource(mysql result)</em></strong> [
    [0] => id | username
    [1] => 1  | raulfraile
    [2] => 2  | ladybug
]</pre>

For example, if you want to add a new dumper for DateTime object, you should 
create a new class in `lib/objects/datetime.php`, that will extend from LadybugExtension
and will have a public method called `dump`.