<?php

/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
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
     * @param mixed One or more variables to dump
     *
     * @return string
     */
    public function dump(/*$var1 [, $var2...$varN]*/)
    {
        $args = func_get_args();
        $this->nodes = $this->readVariables($args);

        return $this->getRender()->render($this->nodes);
    }

    /**
     * Reads variables and creates XType objects
     * @param array $variables variables to dump
     */
    protected function readVariables($variables)
    {
        /** @var FactoryType $factoryType */
        $factoryType = $this->container->get('ladybug.type.__factory');
        $nodes = array();

        foreach ($variables as $var) {
            $nodes[] = $factoryType->factory($var, 0);
        }

        return $nodes;
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

        $this->container->setAttribute('format', $environment->getDefaultFormat());
        $format = $this->container->get(sprintf('format.%s', $environment->getDefaultFormat()));

        /** @var $themeResolver ThemeResolver */
        $themeResolver = $this->container->get('theme.resolver');

        $theme = $themeResolver->resolve();
        $this->container->setAttribute('theme', strtolower($theme->getName()));

        /** @var $render RenderInterface */
        $render = $this->container->get('render.' . $environment->getDefaultFormat());

        $this->container->setAttribute('render', $render);

        return $render;
    }

}
