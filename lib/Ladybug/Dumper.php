<?php

/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

use Ladybug\Type\FactoryType;
use Ladybug\Render\RenderInterface;
use Ladybug\Environment\EnvironmentResolver;
use Ladybug\Theme\ThemeResolver;
use Ladybug\Render\RenderResolver;
use Ladybug\Application;
use Ladybug\Format\FormatResolver;

class Dumper
{

    /** @var array $nodes */
    private $nodes;

    /** @var Application $application */
    protected $application;

    protected $theme;

    protected $format;

    protected $callFile = null;
    protected $callLine = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->theme = null;
        $this->format = null;

        $this->initializeNodes();
        $this->initializeContainer();
    }

    /**
     * Initialize the nodes array
     */
    protected function initializeNodes()
    {
        $this->nodes = array();
    }

    /**
     * Initialize the dependency injection container
     */
    protected function initializeContainer()
    {
        $this->application = new Application();
        $this->application->build();
    }

    /**
     * Dumps one or more variables
     * @param mixed[] One or more variables to dump
     *
     * @return string
     */
    public function dump(/*$var1 [, $var2...$varN]*/)
    {
        $args = func_get_args();
        $this->readVariables($args);
        $this->loadCallLocationInfo();

        $render = $this->getRender();

        return $render->render($this->nodes, array(
            'callFile' => $this->callFile,
            'callLine' => $this->callLine
        ));
    }

    /**
     * Read variables and fill nodes with TypeInterface objects
     * @param array $variables variables to dump
     */
    protected function readVariables($variables)
    {
        /** @var FactoryType $factoryType */
        $factoryType = $this->application->container->get('type_factory');

        foreach ($variables as $var) {
            $this->nodes[] = $factoryType->factory($var, 0);
        }
    }

    /**
     * Returns call location informations.
     *
     * @return array
     */
    public function loadCallLocationInfo()
    {
        $index = 5;
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 6);

        // Check if Ladybug was called from the helpers shortcuts
        $caller = isset($trace[$index]['function']) ? $trace[$index]['function'] : '';
        if (!in_array($caller, array('ld', 'ldd', 'ldr'))) {
            $index = $index - 4;
        }

        $this->callFile = isset($trace[$index]['file']) ? $trace[$index]['file'] : null;
        $this->callLine = isset($trace[$index]['line']) ? $trace[$index]['line'] : null;
    }

    /**
     * Set option value
     * @param string $key   Option key
     * @param mixed  $value Option value
     */
    public function setOption($key, $value)
    {
        $this->application->setAttribute($key, $value);
    }

    /**
     * Get option value
     * @param mixed $key Option key
     *
     * @return mixed
     */
    public function getOption($key)
    {
        return $this->application->getAttribute($key);
    }

    /**
     * Get render object
     *
     * @return RenderInterface
     */
    protected function getRender()
    {
        // environment

        /** @var $environmentResolver EnvironmentResolver */
        $environmentResolver = $this->application->container->get('environment_resolver');
        $environment = $environmentResolver->resolve();

        $format = $environment->getDefaultFormat();
        if (!is_null($this->format)) {
            $format = $this->format;
        } elseif ($this->application->container->hasParameter('format')) {
            $format = $this->application->container->getParameter('format');
        }

        /** @var $formatResolver FormatResolver */
        $formatResolver = $this->application->container->get('format_resolver');
        $format = $formatResolver->getFormat($format);


        /** @var $themeResolver ThemeResolver */
        $themeResolver = $this->application->container->get('theme_resolver');

        if (!is_null($this->theme)) {
            $theme = $themeResolver->getTheme($this->theme, $format);
        } elseif ($this->application->container->hasParameter('theme')) {
            $theme = $themeResolver->getTheme($this->application->container->getParameter('theme'), $format);
        } else {
            $theme = $themeResolver->resolve($format);
        }


        /** @var $renderResolver RenderResolver */
        $renderResolver = $this->application->container->get('render_resolver');

        $render = $renderResolver->resolve($format);
        $render->setTheme($theme);
        $render->setFormat($format);

        return $render;
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    public function getTheme()
    {
        return $this->application->container->get('theme.' . $this->application->container->getParameter('theme'));
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->application->container->get('format.' . $this->application->getParameter('format'));
    }

}
