<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../vendor/autoload.php';
Ladybug\Loader::loadHelpers();

class Foo
{
    const c1 = 1;
    const c2 = '2';

    public $p1 = 1.5;

    public function test($required, $optional = true) {}
}

class ObjectTest extends PHPUnit_Framework_TestCase
{
    protected $date;
    protected $foo;
    protected $t_dumper;
    protected $result;

    protected function setUp()
    {
        $this->date = new DateTime();
        $this->foo = new Foo();
        $this->t_dumper = \Ladybug\Dumper::getInstance();
        $this->result = ladybug_dump_return('php', $this->date, $this->foo, $this->t_dumper);
    }

    public function testObjectGetsRightType()
    {
        $this->assertEquals('object(DateTime)', $this->result['var1']['type']);
        $this->assertEquals('object(Foo)', $this->result['var2']['type']);
        $this->assertEquals('object(Ladybug\\Dumper)', $this->result['var3']['type']);
    }

    public function testObjectGetsRightFilename()
    {
        $this->assertEquals('built-in', $this->result['var1']['value']['class_info']['filename']);
        $this->assertEquals(__FILE__, $this->result['var2']['value']['class_info']['filename']);
    }

    public function testObjectGetsRightConstants()
    {
        $foo_constants = $this->result['var2']['value']['constants'];

        $this->assertEquals(2, count($foo_constants));

        $this->assertEquals('int', $foo_constants['c1']['type']);
        $this->assertEquals(Foo::c1, $foo_constants['c1']['value']);

        $this->assertEquals('string', $foo_constants['c2']['type']);
        $this->assertEquals(Foo::c2, $foo_constants['c2']['value']);
    }

    public function testObjectGetsRightProperties()
    {
        $foo_properties = $this->result['var2']['value']['public_properties'];

        $this->assertEquals(1, count($foo_properties));

        $this->assertEquals('float', $foo_properties['p1']['type']);
        $this->assertEquals($this->foo->p1, $foo_properties['p1']['value']);
    }

    public function testObjectGetsRightMethodsAndParameters()
    {
        $foo_methods = $this->result['var2']['value']['methods'];

        $this->assertEquals(1, count($foo_methods));

        $this->assertEquals('public test($required, [$optional = TRUE])', $foo_methods[0]);
    }
}
