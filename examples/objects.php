<?php

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

// user class
class Foo3 {public $a; public function __construct() {$this->a = new DateTime();}}
class Foo2 {public $a; public function __construct() {$this->a = new Foo3();}}
class Foo
{
    const www = 1;

    public $bar = 1;
    public $bar2 = 2;
    public $a;
    public $b = array(1, 2, 3);
    private $w = 1;
    protected $w2 = 2;

    /**
     * Constructor
     * @return null
     */
    public function __construct() {$this->a = new Foo2();}

    /**
     * Get bar
     *
     * Get the bar value
     *
     * @return int
     */
    protected function getBar() { return $this->bar; }
    private function setBar($a,$b,$c,$d,$bar = 1, $bar2 = TRUE, $bar3 = NULL, $bar4 = "<br/>", array $bar5 = array(1,2,3)) { $this->bar = $bar; }
    public function __toString() {return $this->bar . ' - ' . $this->bar2; }
}

$foo = new Foo();
//ld($foo);



// DateTime object

$date = new DateTime();
//ladybug_dump_die($date);

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

//ladybug_dump($dom);

$reflected = new ReflectionClass('Foo');

//ladybug_dump($reflected);


$dumper = new \Ladybug\Dumper();

echo $dumper->dump($foo, $date, $dom, $reflected);
