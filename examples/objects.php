<?php

require_once __DIR__.'/../lib/Ladybug.php';

// user class

class Foo {
    public $bar = 1;
    public $bar2 = 2;
    
    public function __construct() {}
    public function getBar() { return $this->bar; }
    public function setBar($bar) { $this->bar = $bar; }
}

$foo = new Foo();
ladybug_dump($foo);

// DateTime object

$date = new DateTime();
ladybug_dump($date);


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

ladybug_dump($dom);