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
use Ladybug\Exception\InvalidFormatException;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Pimple;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;

use Ladybug\Theme\ThemeInterface;
use Ladybug\Exception\ThemeNotFoundException;
use Ladybug\Render\RenderInterface;

class Dumper
{

    const ENVIRONMENT_HTML = 'Html';
    const ENVIRONMENT_CLI = 'Cli';
    const ENVIRONMENT_TXT = 'Text';

    const EXPORT_FORMAT_PHP  = 'php';
    const EXPORT_FORMAT_YAML = 'yaml';
    const EXPORT_FORMAT_JSON = 'json';
    const EXPORT_FORMAT_XML  = 'xml';

    private static $tree_counter = 0;
    private static $assetsLoaded = false;

    private $isCssLoaded;
    private $nodes;
    private $options;

    protected $container;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isCssLoaded = false;
        $this->options = new Options();

        $this->container = new Pimple();

        $this->container['options'] = $this->container->share(function ($c) {
            return new Options();
        });



    }

    /**
     * Dumps one or more variables
     * @param vars one or more variables to dump
     * @return string
     */
    public function dump(/*$var1 [, $var2...$varN]*/)
    {
        $args = func_get_args();
        $this->nodes = $this->readVars($args);

        $env = $this->getEnvironment();

        $render = $this->getRender($env);

        return $render->render($this->nodes);
    }

    /**
     * Exports one or more variables to the selected format
     * Available formats: php (for testing purposes), yaml, xml and json
     * @param vars format and variables to dump
     */
    public function export(/*$format, $var1 [, $var2...$varN]*/)
    {
        $args = func_get_args();

        $format = strtolower($args[0]);
        $vars = array_slice($args, 1);

        $this->nodes = $this->readVars($vars);

        $response = null;

        $exportArray = array();
        $i=1;
        foreach ($this->nodes as $v) {
            $exportArray['var' . $i] = $v->export();
            $i++;
        }

        switch ($format) {
            case self::EXPORT_FORMAT_PHP:
                $response = $exportArray;
                break;
            case self::EXPORT_FORMAT_YAML:
                $yaml = new \Symfony\Component\Yaml\Yaml();
                $response = $yaml->dump($exportArray);
                break;
            case self::EXPORT_FORMAT_XML:
                $serializer = new \Symfony\Component\Serializer\Encoder\XmlEncoder();
                $response = $serializer->encode($exportArray, 'xml');
                break;
            case self::EXPORT_FORMAT_JSON:
                $response = json_encode($exportArray);
                break;
            default:
                throw new InvalidFormatException();
        }

        return $response;
    }

    /**
     * Reads variables and creates TType objects
     * @param array $vars variables to dump
     */
    protected function readVars($vars)
    {
        $nodes = array();

        foreach ($vars as $var) {
            $nodes[] = FactoryType::factory($var, 0, $this->container);
        }

        return $nodes;
    }



    /**
     * Triggers the html post-processors
     * @param  string $str HTML code
     * @return string processed string
     */
    private function _postProcess($str)
    {
        $result = $str;

        if ($this->options->getOption('processor.active')) {
            $dir = dir(__DIR__. '/Processor');

            while (false !== ($file = $dir->read())) {
                if (strpos($file, '.php') !== false && strpos($file, 'Interface.php') === false) {
                    $class = 'Ladybug\\Processor\\' . str_replace('.php', '', $file);

                    $processorObject = new $class();

                    if ($processorObject->isProcessable($result)) {
                        $result = $processorObject->process($result);
                    }

                    unset($processorObject);
                }
            }
            $dir->close();
        }

        return $result;
    }

    /**
     * Increments and returns the tree counter
     * @return int tree id
     */
    public static function getTreeId()
    {
        return ++self::$tree_counter;
    }

    /**
     * Returns true if the script is being executed in CLI
     * @return boolean
     */
    private function _isCli()
    {
        return 'cli' === php_sapi_name();
    }

    /**
     * Returns true if the request is a XMLHttpRequest.
     *
     * It works if your JavaScript library set an X-Requested-With HTTP header.
     * It is known to work with Prototype, Mootools, jQuery.
     *
     * @return Boolean true if the request is an XMLHttpRequest, false otherwise
     */
    public function isXmlHttpRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XMLHttpRequest' == $_SERVER['HTTP_X_REQUESTED_WITH'];
    }

    public function setOption($key, $value)
    {
        $this->options->setOption($key, $value);
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

    public function getEnvironment()
    {
        if (true === $this->_isCli()) {
            return self::ENVIRONMENT_CLI;
        } elseif ($this->isXmlHttpRequest()) {
            return self::ENVIRONMENT_TXT;
        }

        return self::ENVIRONMENT_HTML;
    }

    /**
     * @throws Exception\ThemeNotFoundException
     *
     * @return RenderInterface
     */
    public function getRender($environment)
    {
        $themeClass = '\\Ladybug\\Theme\\' . $this->options->getOption('theme') . '\\' . $this->options->getOption('theme') . 'Theme';

        if (!class_exists($themeClass)) {
            throw new ThemeNotFoundException();
        }

        /** @var $theme ThemeInterface */
        $theme = new $themeClass();


        if (!in_array($environment, $theme->getEnvironments())) {
            $found = false;
            while (!is_null($theme->getParent()) && !$found) {
                $themeClass = '\\Ladybug\\Theme\\' . $theme->getParent() . '\\' . $theme->getParent() . 'Theme';

                /** @var $theme ThemeInterface */
                $theme = new $themeClass();

                if (in_array($environment, $theme->getEnvironments())) {
                    $found = true;
                }
            }

            if (!$found) {
                var_dump('error');die();
            }
        }

        $rendererClass = '\\Ladybug\\Render\\' . $environment . 'Render';
        $renderer = new $rendererClass($theme);

        return $renderer;
    }
}
