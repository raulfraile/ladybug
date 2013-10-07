<?php

namespace Ladybug\Tests\Theme;

use Ladybug\Theme\ThemeResolver;
use Ladybug\Theme\ThemeInterface;
use Ladybug\Format\HtmlFormat;
use \Mockery as m;

class ThemeResolverTest extends \PHPUnit_Framework_TestCase
{

    /** @var ThemeResolver */
    protected $resolver;

    protected $theme;

    public function setUp()
    {
        $this->resolver = new ThemeResolver();

        $this->theme = m::mock('Ladybug\Theme\ThemeInterface');
        $this->theme->shouldReceive('getFormats')->andReturn(array(HtmlFormat::FORMAT_NAME));
    }

    public function tearDown()
    {
        m::close();
    }

    public function testAddTheme()
    {
        $result = $this->resolver->addTheme($this->theme, 'theme_test');

        $this->assertTrue($result);
        $this->assertCount(1, $this->resolver);
    }

    public function testGetRegisteredTheme()
    {
        $this->resolver->addTheme($this->theme, 'theme_test');

        $this->assertInstanceOf('Ladybug\Theme\ThemeInterface', $this->resolver->getTheme('test', 'html'));
    }

    public function testGetDefaultThemeWhenDoesNotExist()
    {
        $this->resolver->addTheme($this->theme, 'theme_test');
        $this->resolver->addTheme($this->theme, 'theme_test_default', true);

        $this->assertInstanceOf('Ladybug\Theme\ThemeInterface', $this->resolver->getTheme('notfound', HtmlFormat::FORMAT_NAME));
    }


}
