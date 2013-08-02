<?php

require_once __DIR__.'/../vendor/autoload.php';

// user class
class Foo
{
    const TEST = 1;

    public $bar = 1;
    protected $extra;


    /**
     * Constructor
     *
     * @return null
     */
    public function __construct() {
        $this->extra = new \stdClass();
        $this->extra->a1 = 1;
    }

    /**
     * Get bar
     *
     * Get the bar value
     *
     * @return int
     */
    protected function getBar() { return $this->bar; }
    private function setBar($bar=array(1,2)) { $this->bar = $bar; }
    public function __toString() {return $this->bar; }
}

$foo = new Foo();

// DateTime object

$date = new DateTime();

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

$reflected = new ReflectionClass('Foo');

ladybug_set_format('text');

ladybug_dump($foo, $dom, $reflected, $date);
