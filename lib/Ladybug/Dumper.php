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
use Ladybug\Container;

class Dumper
{

    /** @var array $nodes */
    private $nodes;

    /** @var Container $container */
    protected $container;

    protected $callFile;
    protected $callLine;
    protected $callClass;
    protected $callFunction;

    /**
     * Constructor
     */
    public function __construct()
    {
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
        $this->container = new Container();
        $this->container->load();
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

        $render = $this->getRender();

        return $render->render($this->nodes);
    }

    /**
     * Read variables and fill nodes with TypeInterface objects
     * @param array $variables variables to dump
     */
    protected function readVariables($variables)
    {
        /** @var FactoryType $factoryType */
        $factoryType = $this->container->get('ladybug.type.__factory');

        foreach ($variables as $var) {
            $this->nodes[] = $factoryType->factory($var, 0);
        }
    }

    /**
     * Returns call location informations.
     *
     * @return array
     */
    public static function getCallLocationInfos()
    {
        $idx = 7;
        $bt = debug_backtrace();

        // Check if Ladybug was called from the helpers shortcuts
        $caller = isset($bt[$idx]['function']) ? $bt[$idx]['function'] : '';
        if (!in_array($caller, array('ld', 'ldd', 'ldr'))) {
            $idx = $idx - 2;
        }

        return array(
            'caller'   => isset($bt[$idx]['function']) ? $bt[$idx]['function'] : '',
            'file'     => isset($bt[$idx]['file']) ? $bt[$idx]['file'] : '',
            'line'     => isset($bt[$idx]['line']) ? $bt[$idx]['line'] : '',
            'class'    => isset($bt[$idx + 1]['class'])    ? $bt[$idx + 1]['class'] : '',
            'function' => isset($bt[$idx + 1]['function']) ? $bt[$idx + 1]['function'] : ''
        );
    }

    /**
     * Set option value
     * @param string $key   Option key
     * @param mixed  $value Option value
     */
    public function setOption($key, $value)
    {
        $this->container->setAttribute($key, $value);
    }

    /**
     * Get option value
     * @param mixed $key Option key
     *
     * @return mixed
     */
    public function getOption($key)
    {
        return $this->container->getAttribute($key);
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
        $environmentResolver = $this->container->get('environment.resolver');
        $environment = $environmentResolver->resolve();

        if (!$this->container->getAttribute('format_force', false)) {
            $this->container->setAttribute('format', $environment->getDefaultFormat());
        }

        /** @var $themeResolver ThemeResolver */
        //$themeResolver = $this->container->get('theme.resolver');

        $theme = $this->getTheme();
        $this->container->setAttribute('theme', strtolower($theme->getName()));

        /** @var $render RenderInterface */
        $render = $this->container->get('render.' . $this->container->getAttribute('format'));

        $this->container->setAttribute('render', $render);

        return $render;
    }

    public function setTheme($theme)
    {
        $this->container->setParameter('theme', $theme);
    }

    public function getTheme()
    {
        return $this->container->get('theme.' . $this->container->getParameter('theme'));
    }

    public function setFormat($format)
    {
        $this->container->setAttribute('format', $format);
        $this->container->setAttribute('format_force', true);
    }

    public function getFormat()
    {
        return $this->container->get('format.' . $this->container->getParameter('format'));
    }

}
