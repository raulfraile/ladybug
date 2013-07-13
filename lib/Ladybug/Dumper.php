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
            'callLine' => $this->callLine,
            'id' => uniqid()
        ));

        echo '<iframe id="i" frameborder="0" width="500" height="100"></iframe>
<script>
        var l=document.getElementById("i").contentWindow.document;
        l.open();
        l.write("<style>" + document.getElementById("ladybug_css").innerHTML + "</style>" +
         "<script>" + document.getElementById("ladybug_js").innerHTML + "\<\/script>" + document.getElementById("ladybug_content").innerHTML);
        l.close();
        var height = l.body.scrollHeight;
        var width = l.body.scrollWidth;
        document.getElementById("i").height = (height+10) + "px";
        document.getElementById("i").width = (width+10) + "px";
        console.log(height + "px");
        </script>';
        /*die();
        return $render->render($this->nodes, array(
            'callFile' => $this->callFile,
            'callLine' => $this->callLine
        ));*/
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
        $this->theme = $theme;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

}
