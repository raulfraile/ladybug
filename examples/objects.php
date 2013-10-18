<?php

require_once __DIR__.'/../vendor/autoload.php';

// DateTime object
$date = new DateTime();

// DOMDocument object
$sXml = <<<XML
<books>
    <book id="1">
        <title>PHP 5 Power Programming</title>
        <author>Andi Gutmans, Stig Bakken, Derick Rethans</author>
    </book>
    <book id="2">
        <title>Clean Code: A Handbook of Agile Software Craftsmanship</title>
        <author>Robert C. Martin</author>
    </book>
</books>
XML;
$dom = new DOMDocument();
$dom->loadXml($sXml);

// ReflectionClass object
$reflected = new ReflectionClass('\Ladybug\Dumper');

$ladybug = new \Ladybug\Dumper();

$s = new \stdClass();
$s->a = 1;

echo $ladybug->dump($ladybug, $s, new \Symfony\Component\Finder\Finder(), /*$dom, $reflected, */$date/*, function() { echo 1; }*/);
