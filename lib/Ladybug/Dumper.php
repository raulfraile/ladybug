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

class Dumper {
    const EXPORT_FORMAT_PHP = 'php';
    const EXPORT_FORMAT_YAML = 'yaml';
    const EXPORT_FORMAT_JSON = 'json';
    const EXPORT_FORMAT_XML = 'xml';
    
    private static $instance = null;
    
    private static $tree_counter = 0;

    private $is_css_loaded;
    private $is_cli;
    
    private $nodes;
    private $options;
    
    /**
     * Constructor. Private (singleton pattern)
     * @return Get singleton instance
     */
    public function __construct() {
        $this->is_css_loaded = FALSE;
        $this->is_cli = $this->_isCli();
        $this->options = new Options();
    }
    
    /**
     * Singleton method
     * @return Get singleton instance
     */
    public static function getInstance() {
        return (self::$instance !== null) ? self::$instance : (self::$instance = new Dumper()); 
    }
    
    /**
     * Dumps one or more variables
     * @param vars one or more variables to dump
     */
    public function dump(/*$var1 [, $var2...$varN]*/) {
        $args = func_get_args();
        $this->nodes = $this->_readVars($args);
        
        // generate html/console code
        if (!$this->is_cli) {
            $html = $this->_render('html');
            unset($result); $result = NULL;

            // post-processors
            $html = $this->_postProcess($html);
        
            return $html;
        }
        else {
            $code = $this->_render('cli');
            
            return $code;
        }
    }
    
    /**
     * Exports one or more variables to the selected format
     * Available formats: php (for testing purposes), yaml, xml and json
     * @param vars format and variables to dump
     */
    public function export(/*$format, $var1 [, $var2...$varN]*/) {
        $args = func_get_args();
        
        $format = strtolower($args[0]);
        $vars = array_slice($args, 1);
        
        $this->nodes = $this->_readVars($vars);
        
        $response = null;
        
        $export_array = array();
        $i=1;
        foreach ($this->nodes as $k => $v) {
            $export_array['var' . $i] = $v->export();
            $i++;
        }
        
        switch ($format) {
            case self::EXPORT_FORMAT_PHP:
                $response = $export_array;
                break;
            case self::EXPORT_FORMAT_YAML:
                $yaml = new \Symfony\Component\Yaml\Yaml();
                $response = $yaml->dump($export_array);
                break;
            case self::EXPORT_FORMAT_XML:
                $serializer = new \Symfony\Component\Serializer\Encoder\XmlEncoder();
                $response = $serializer->encode($export_array, 'xml');
                break;
            case self::EXPORT_FORMAT_JSON:
                $response = json_encode($export_array);
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
    private function _readVars($vars) {
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
    private function _render($format = 'html') {
        if ($format == 'html') return $this->_renderHTML();
        else return $this->_renderCLI();
    }
    
    /**
     * Renders the variables into HTML format
     */
    private function _renderHTML() {
        $html = '';
        $css = '';
        
        foreach ($this->nodes as $var) {
            $html .= '<li>'.$var->render().'</li>';
        }
        
        if (!$this->is_css_loaded) {
            $this->is_css_loaded = TRUE;
            $css = '<style>' . file_get_contents(__DIR__.'/Asset/tree.min.css') . '</style>';
        }
        
        $html = '<pre><ol class="tree">' . $html . '</ol></pre>';
        return $css . $html;
    }
    
    /**
     * Renders the variables into CLI format
     */
    private function _renderCLI() {
        $result = '';
        
        foreach ($this->nodes as $var) {
            $result .= $var->render(NULL, 'cli');
        }
        
        $result .= "\n";
        
        return $result;
    }
    
    /**
     * Triggers the html post-processors
     * @param $str html code
     */
    private function _postProcess($str) {
        $result = $str;
        
        if ($this->options->getOption('processor.active')) {
            $dir = dir(__DIR__. '/Processor');

            while (false !== ($file = $dir->read())) {
                if (strpos($file, '.php') !== FALSE) {
                    $class = 'Ladybug\\Processor\\' . str_replace('.php', '', $file);
                    $processor_object = new $class();

                    $result = $processor_object->process($result);
                    
                    unset($processor_object);
                }
            }
            $dir->close();
        }
        return $result;
    }
    
    
    
    
    public static function getTreeId() {
        return ++self::$tree_counter;
    }
    
    private function _isCli() {
        $sapi_type = php_sapi_name();
        
        if ($sapi_type == 'cli') return TRUE;
        else return FALSE;
    }
    
    public function setOption($key, $value) {
        $this->options->setOption($key, $value);
    }
}
