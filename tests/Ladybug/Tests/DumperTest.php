<?php

namespace Ladybug\Tests;

use Ladybug\Dumper;
use Ladybug\Format;
use Symfony\Component\DomCrawler\Crawler;

class DumperTest extends \PHPUnit_Framework_TestCase
{

    /** @var Dumper $dumper */
    protected $dumper;

    public function setUp()
    {
        $this->dumper = new Dumper();
        $this->dumper->setFormat(Format\PhpFormat::FORMAT_NAME);
        $this->dumper->setTheme('base');
    }

    public function testDumpSimpleVariable()
    {
        $var = 1;
        $dump = $this->dumper->dump($var);
        $this->assertCount(1, $dump['nodes']);
    }

    public function testDumpMultipleVariables()
    {
        $var1 = 1;
        $var2 = 2;
        $dump = $this->dumper->dump($var1, $var2);
        $this->assertCount(2, $dump['nodes']);
    }

    public function testThemeCanBeSet()
    {
        $this->dumper->setTheme('modern');
        $this->assertEquals('modern', $this->dumper->getTheme());
    }

    public function testFormatCanBeSet()
    {
        $this->dumper->setFormat(Format\XmlFormat::FORMAT_NAME);
        $this->assertEquals(Format\XmlFormat::FORMAT_NAME, $this->dumper->getFormat());
    }

    public function testDumpHtmlFormat()
    {
        $var = 1;

        $this->dumper->setFormat(Format\HtmlFormat::FORMAT_NAME);
        $dump = $this->dumper->dump($var);
var_dump($dump);
        $crawler = new Crawler($dump);

        $this->assertEquals('int', $crawler->filterXPath('//span[@class="type"]')->text());
        $this->assertEquals(1, $crawler->filterXPath('//span[@class="value"]')->text());
    }

    public function testDumpTextFormat()
    {
        $var = 1;

        $this->dumper->setFormat(Format\TextFormat::FORMAT_NAME);
        $dump = $this->dumper->dump($var);

        $this->assertEquals('int 1' . PHP_EOL, $dump);

    }

    public function testDumpJsonFormat()
    {
        $var = 1;

        $this->dumper->setFormat(Format\JsonFormat::FORMAT_NAME);
        $dump = json_decode($this->dumper->dump($var));

        $this->assertObjectHasAttribute('id', $dump[0]);
        $this->assertObjectHasAttribute('type', $dump[0]);
        $this->assertObjectHasAttribute('value', $dump[0]);

        $this->assertEquals('int', $dump[0]->type);
        $this->assertEquals(1, $dump[0]->value);
    }

    public function testDumpXmlFormat()
    {
        $var = 1;

        $this->dumper->setFormat(Format\XmlFormat::FORMAT_NAME);
        $dump = new \SimpleXMLElement($this->dumper->dump($var));

        $this->assertEquals(1, $dump->entry->count());
        $this->assertEquals('int', $dump->entry[0]['type']);
        $this->assertEquals('1', $dump->entry[0]->value);
    }

}
