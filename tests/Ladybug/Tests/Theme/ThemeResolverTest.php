<?php

namespace Ladybug\Tests\Theme;

use Ladybug\Theme\ThemeResolver;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Format\HtmlFormat;
use Ladybug\Format\ConsoleFormat;
use Ladybug\Format\XmlFormat;
use \Mockery as m;

class ThemeResolverTest extends \PHPUnit_Framework_TestCase
{

    /** @var ThemeResolver */
    protected $resolver;

    protected $baseTheme;
    protected $htmlTheme;

    public function setUp()
    {
        $this->resolver = new ThemeResolver();

        $this->baseTheme = m::mock('Ladybug\Theme\ThemeInterface');
        $this->baseTheme->shouldReceive('getFormats')->andReturn(array(
            HtmlFormat::FORMAT_NAME,
            ConsoleFormat::FORMAT_NAME
        ));
        $this->baseTheme->shouldReceive('getParent')->andReturn(null);

        $this->htmlTheme = m::mock('Ladybug\Theme\HtmlThemeInterface');
        $this->htmlTheme->shouldReceive('getFormats')->andReturn(array(HtmlFormat::FORMAT_NAME));
    }

    public function tearDown()
    {
        m::close();
    }

    public function testAddTheme()
    {
        $result = $this->resolver->addTheme($this->htmlTheme, 'theme_test');

        $this->assertTrue($result);
        $this->assertCount(1, $this->resolver);
    }

    public function testGetRegisteredTheme()
    {
        $this->resolver->addTheme($this->htmlTheme, 'theme_test');

        $this->assertInstanceOf('Ladybug\Theme\ThemeInterface', $this->resolver->getTheme('test', 'html'));
    }

    public function testGetDefaultThemeWhenDoesNotExist()
    {
        $this->resolver->addTheme($this->htmlTheme, 'theme_test');
        $this->resolver->addTheme($this->htmlTheme, 'theme_test_default', true);

        $this->assertInstanceOf('Ladybug\Theme\ThemeInterface', $this->resolver->getTheme('notfound', HtmlFormat::FORMAT_NAME));
    }

    public function testGetFalseWhenDoesNotExistAndNoDefaultTheme()
    {
        $this->resolver->addTheme($this->htmlTheme, 'theme_test');

        $this->assertFalse($this->resolver->getTheme('notfound', HtmlFormat::FORMAT_NAME));
    }

    public function testGetParentThemeWhenSelectedNotAcceptFormat()
    {
        $this->htmlTheme->shouldReceive('getParent')->andReturn('base');

        $this->resolver->addTheme($this->baseTheme, 'theme_base');
        $this->resolver->addTheme($this->htmlTheme, 'theme_test');

        $this->assertInstanceOf('Ladybug\Theme\ThemeInterface', $this->resolver->getTheme('test', ConsoleFormat::FORMAT_NAME));
    }

    public function testGetFalseWhenSelectedNotAcceptFormat()
    {
        $this->htmlTheme->shouldReceive('getParent')->andReturn('base');

        $this->resolver->addTheme($this->baseTheme, 'theme_base');
        $this->resolver->addTheme($this->htmlTheme, 'theme_test');

        $this->assertFalse($this->resolver->getTheme('test', XmlFormat::FORMAT_NAME));
    }


}
