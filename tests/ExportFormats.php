<?php
require_once 'PHPUnit/Framework/TestCase.php';

require_once __DIR__.'/../lib/Ladybug/Autoloader.php';
Ladybug\Ladybug_Autoloader::register();

class ExportFormatsTest extends PHPUnit_Framework_TestCase
{
    public $vars;
    
    public function setUp() {
        $this->vars = array(
            1,
            1.0,
            null,
            'hello world',
            array(1, 2, 3),
            new \DateTime()
        );
    }
    
    public function testExportYamlFormat() {
        $yaml = ladybug_dump_return('yaml', $this->vars[0], $this->vars[1], $this->vars[2], $this->vars[3], $this->vars[4], $this->vars[5]);
        $this->assertEquals(file_get_contents(__DIR__ . '/files/test.yml'), $yaml);
    }
    
    public function testExportXmlFormat() {
        $yaml = ladybug_dump_return('xml', $this->vars[0], $this->vars[1], $this->vars[2], $this->vars[3], $this->vars[4], $this->vars[5]);
        $this->assertEquals(file_get_contents(__DIR__ . '/files/test.xml'), $yaml);
    }   
    
    public function testExportJsonFormat() {
        $yaml = ladybug_dump_return('json', $this->vars[0], $this->vars[1], $this->vars[2], $this->vars[3], $this->vars[4], $this->vars[5]);
        $this->assertEquals(file_get_contents(__DIR__ . '/files/test.json'), $yaml);
    }
    
    /**
     * @expectedException Ladybug\Exception\InvalidFormatException
     */
    public function testUnknownFormatThrowsException() {
        $yaml = ladybug_dump_return('unknown', $this->vars[0], $this->vars[1], $this->vars[2], $this->vars[3], $this->vars[4], $this->vars[5]);
        $this->assertEquals(file_get_contents(__DIR__ . '/files/test.json'), $yaml);
    }   
}
