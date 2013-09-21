<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
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

/**
 * Main Ladybug class
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class Dumper
{
    const LEVEL_INIT = 1;

    /** @var array $nodes */
    protected $nodes;

    /** @var Application $application */
    protected $application;

    /** @var bool $isApplicationInitialized */
    protected $isApplicationInitialized;

    /** @var string $callFile */
    protected $callFile = null;

    /** @var int $callLine */
    protected $callLine = null;

    /** @var array $options */
    protected $options;

    protected $helpers = array();

    protected $shortcuts = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->isApplicationInitialized = false;

        $this->options = array();

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
        if ($this->isApplicationInitialized) {
            return;
        }

        $this->application = new Application();
        $this->application->build($this->options);

        $this->registerHelper(sprintf('%s:%s', get_class($this), 'dump'));

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

        if ($this->application->container->getParameter('silenced', false)) {
            return null;
        }

        $this->initializeNodes();

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
     * @param array $variables Variables to dump
     */
    protected function readVariables($variables)
    {
        /** @var FactoryType $factoryType */
        $factoryType = $this->application->container->get('type_factory');

        foreach ($variables as $var) {
            $node = $factoryType->factory($var, self::LEVEL_INIT);

            $this->nodes[] = $node;
        }
    }

    /**
     * Returns call location informations.
     *
     * @return array
     */
    public function loadCallLocationInfo()
    {
        $this->callFile = null;
        $this->callLine = null;

        $backtrace = debug_backtrace();
        $backtraceCount = count($backtrace);
        $idx = $backtraceCount - 1;
        $found = false;

        while ($idx > 0 && !$found) {
            $callable = isset($backtrace[$idx]['class']) ? $backtrace[$idx]['class'] . ':' . $backtrace[$idx]['function'] : $backtrace[$idx]['function'];

            if (in_array($callable, $this->application->container->getParameter('helpers'))) {
                $this->callFile = isset($backtrace[$idx]['file']) ? $backtrace[$idx]['file'] : null;
                $this->callLine = isset($backtrace[$idx]['line']) ? $backtrace[$idx]['line'] : null;

                return;
            }

            $idx--;
        }

    }

    public function registerHelper($name)
    {
        $this->helpers[] = $name;
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

        $format = $this->getOption('format');
        if (is_null($format)) {
            $format = $environment->getDefaultFormat();
        }

        /** @var $formatResolver FormatResolver */
        $formatResolver = $this->application->container->get('format_resolver');
        $format = $formatResolver->getFormat($format);

        /** @var $themeResolver ThemeResolver */
        $themeResolver = $this->application->container->get('theme_resolver');

        if ($this->application->container->hasParameter('theme')) {
            $theme = $themeResolver->getTheme($this->application->container->getParameter('theme'), $format->getName());
        } else {
            $theme = $themeResolver->resolve($format);
        }

        /** @var $renderResolver RenderResolver */
        $renderResolver = $this->application->container->get('render_resolver');

        $render = $renderResolver->resolve($format);
        $render->setTheme($theme);
        //$render->setFormat($format);
        return $render;
    }

    /**
     * Set theme
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->setOption('theme', $theme);
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->getOption('theme', 'base');
    }

    /**
     * Set format
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->setOption('format', $format);
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->getOption('format');
    }

    /**
     * Set option
     * @param string $name  Option name
     * @param mixed  $value Option value
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Get option
     * @param string $name    Option name
     * @param mixed  $default Default value
     *
     * @return mixed|null
     */
    public function getOption($name, $default = null)
    {
        return array_key_exists($name, $this->options) ? $this->options[$name] : $default;
    }

    /**
     * Set options
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = array();

        foreach ($options as $name => $value) {
            $this->setOption($name, $value);
        }
    }

    /**
     * Gets options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

}
