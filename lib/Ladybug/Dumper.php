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

    protected $applicationInitialized;

    protected $theme;

    protected $format;

    protected $callFile = null;
    protected $callLine = null;

    protected $options;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->theme = null;
        $this->format = null;
        $this->options = array();
        $this->applicationInitialized = false;

        $this->initializeNodes();

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
    protected function initializeApplication()
    {
        if ($this->applicationInitialized) {
            return;
        }

        $this->application = new Application();
        $this->application->build($this->options);
    }

    /**
     * Dumps one or more variables
     * @param mixed[] One or more variables to dump
     *
     * @return string
     */
    public function dump(/*$var1 [, $var2...$varN]*/)
    {
        $this->initializeApplication();

        $args = func_get_args();
        $this->readVariables($args);
        $this->loadCallLocationInfo();

        $render = $this->getRender();
        $render->setGlobals(array(
            'id' => uniqid(),
            'expanded' => $this->application->container->getParameter('expanded')
        ));

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
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 7);

        $lastTrace = array_pop($trace);

        $this->callFile = isset($lastTrace['file']) ? $lastTrace['file'] : null;
        $this->callLine = isset($lastTrace['line']) ? $lastTrace['line'] : null;
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
        $this->setOption('theme', $theme);
    }

    public function getTheme()
    {
        return $this->getOption('theme', 'base');
    }

    public function setFormat($format)
    {
        $this->setOption('format', $format);
    }

    public function getFormat()
    {
        return $this->getOption('format');
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOption($name, $default = null)
    {
        return array_key_exists($name, $this->options) ? $this->options[$name] : $default;
    }


}
