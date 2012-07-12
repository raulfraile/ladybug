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

use Ladybug\Type\TFactory;
use Ladybug\Exception\InvalidFormatException;

class Dumper
{
    const EXPORT_FORMAT_PHP  = 'php';
    const EXPORT_FORMAT_YAML = 'yaml';
    const EXPORT_FORMAT_JSON = 'json';
    const EXPORT_FORMAT_XML  = 'xml';

    private static $instance = null;

    private static $tree_counter = 0;

    private $isCssLoaded;
    private $nodes;
    private $options;

    /**
     * Constructor. Private (singleton pattern)
     * @return Get singleton instance
     */
    public function __construct()
    {
        $this->isCssLoaded = false;
        $this->options = new Options();
    }

    /**
     * Singleton method
     * @return Get singleton instance
     */
    public static function getInstance()
    {
        return (self::$instance !== null) ? self::$instance : (self::$instance = new Dumper());
    }

    /**
     * Dumps one or more variables
     * @param vars one or more variables to dump
     * @return string
     */
    public function dump(/*$var1 [, $var2...$varN]*/)
    {
        $args = func_get_args();
        $this->nodes = $this->_readVars($args);

        // generate CONSOLE code
        if (true === $this->_isCli()) {
            return $this->_render('cli');
        }
        // generate TEXT code
        if ($this->isXmlHttpRequest()) {
            return $this->_render('txt');
        }
        // generate HTML code
        $html = $this->_render('html');

        // post-processors
        $html = $this->_postProcess($html);

        return $html;
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

        $this->nodes = $this->_readVars($vars);

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
     * @param vars variables to dump
     */
    private function _readVars($vars)
    {
        $nodes = array();

        foreach ($vars as $var) {
            $nodes[] = TFactory::factory($var, 0, $this->options);
        }

        return $nodes;
    }

    /**
     * Renders the variables into the selected format
     * @param format dump format (html, cli)
     */
    private function _render($format = 'html')
    {
        if ($format == 'html') {
            return $this->_renderHTML();
        }
        if ($format == 'txt') {
            return $this->_renderTXT();
        }
        return $this->_renderCLI();
    }

    /**
     * Renders the variables into HTML format
     */
    private function _renderHTML()
    {
        $html = '';
        $css = '';

        foreach ($this->nodes as $var) {
            $html .= '<li>'.$var->render().'</li>';
        }

        if (!$this->isCssLoaded) {
            $this->isCssLoaded = true;
            $css = '<style>' . file_get_contents($this->options->getOption('css.path')) . '</style>';
        }

        $html = '<pre class="ladybug"><ol class="tree">' . $html . '</ol></pre>';

        return $css . $html;
    }

    /**
     * Renders the variables into CLI format
     * @return string
     */
    private function _renderCLI()
    {
        $result = '';

        foreach ($this->nodes as $var) {
            $result .= $var->render(null, 'cli');
        }

        $result .= "\n";

        return $result;
    }

    /**
     * Renders the variables into TXT format
     * @return string
     */
    private function _renderTXT()
    {
        $result = '';

        foreach ($this->nodes as $var) {
            $result .= $var->render(null, 'txt');
        }

        $result .= "\n";

        return $result;
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
}
