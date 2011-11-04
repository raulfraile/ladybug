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
``` html
    <pre><strong><em>string(12)</em></strong> <span style="color:#080">"hello world!"</span></pre>
```
