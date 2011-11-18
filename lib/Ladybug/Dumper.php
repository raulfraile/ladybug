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

class Dumper {
    
    const EXTENSIONS_FOLDER = 'Extension';
    const OBJECTS_FOLDER = 'Object';
    const RESOURCES_FOLDER = 'Resource';
    
    const MAX_NESTING_LEVEL_ARRAYS = 8;
    const MAX_NESTING_LEVEL_OBJECTS = 3;
    
    private static $instance = null;
    private static $tree_counter = 0;
    
    private $is_css_loaded;
    private $is_cli;
    
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
     * Creates the tree and dump one or more variables
     * @param vars one or more variables to dump
     */
    public function dump(/*$var1 [, $var2...$varN]*/) {
        $args = func_get_args();
        $num_args = func_num_args();
        
        $result = array();
        
        foreach ($args as $var) {
            $result[] = TFactory::factory($var, 0, $this->options);
        }
        
        // generate html/console code
        if (!$this->is_cli) {
            $html = $this->_render($result, 'html');
            unset($result); $result = NULL;

            // post-processors
            $html = $this->_postProcess($html);
        
            return $html;
        }
        else {
            $code = $this->_render($result, 'cli');
            
            return $code;
        }
    }
    
    private function _render($vars, $format = 'html') {
        if ($format == 'html') return $this->_renderHTML($vars);
        else return $this->_renderCLI($vars);
    }
    
    private function _renderHTML($vars) {
        $html = '';
        $css = '';
        
        foreach ($vars as $var) {
            $html .= '<li>'.$var->render().'</li>';
        }
        
        if (!$this->is_css_loaded) {
            $this->is_css_loaded = TRUE;
            $css = '<style>' . file_get_contents(__DIR__.'/Asset/tree.min.css') . '</style>';
        }
        
        $html = '<pre><ol class="tree">' . $html . '</ol></pre>';
        return $css . $html;
    }
    
    private function _renderCLI($vars) {
        $result = '';
        
        foreach ($vars as $var) {
            $result .= $var->render(NULL, 'cli');
        }
        
        $result .= "\n";
        
        return $result;
    }
    
    
    private function _postProcess($str) {
        $result = $str;
        
        if ($this->options->getOption('processor.active')) {
            $dir = dir(__DIR__. '/Processor');

            while (false !== ($file = $dir->read())) {
                if (strpos($file, '.php') !== FALSE) {
                    $class = 'Ladybug\\Processor\\' . str_replace('.php', '', $file);
                    $processor_object = new $class();

                    $result = $processor_object->process($result);
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
