<?php

namespace Ladybug;

class Variable {
    // html color constants
    
    protected $html_colors = array(
        'string' => '#080',
        'int' => '#800',
        'float' => '#800',
        'bool' => '#008',
    );
    
    protected $cli_colors = array(
        'string' => 'green',
        'int' => 'red',
        'float' => 'red',
        'bool' => 'blue',
    );
    
    protected $type;
    protected $value;
    protected $level;
    
    public function __construct($type, $value = NULL, $level = 0) {
        $this->type = $type;
        $this->value = $value;
        $this->level = $level + 1;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function setValue($value) {
        $this->value = $value;
    }
    
    public function getLevel() {
        return $this->level;
    }
    
    public function setLevel($level) {
        $this->level = $level;
    }
    
    protected function getColor($format = 'html') {
        if ($format == 'html' && isset($this->html_colors[$this->type])) return $this->html_colors[$this->type];
        elseif ($format == 'cli' && isset($this->html_colors[$this->type])) return $this->cli_colors[$this->type];
        else return NULL;
    }
    
    /*protected function renderSimpleVariable($format, $array_key = NULL) {
        if ($format == 'html') return '<div class="final">'.$this->renderArrayKey($array_key).'<strong><em>'.$this->type.'</em></strong> <span style="color:'.$this->getColor('html').'">'.$this->getValue().'</span></div>';
        else return $this->renderArrayKey($array_key) . $this->type . ' '. CLIColors::getColoredString ($this->getValue(), $this->getColor('cli')) . "\n";
    }*/
    
    public function render($array_key = NULL, $format = 'html') {
        if ($format == 'html') return $this->_renderHTML($array_key);
        elseif ($format == 'cli') return $this->_renderCLI($array_key);
        else return NULL;
    }
    
    protected function _renderHTML($array_key = NULL) {
        return '<div class="final">'.$this->renderArrayKey($array_key).'<strong><em>'.$this->type.'</em></strong> <span style="color:'.$this->getColor('html').'">'.$this->getValue().'</span></div>';
    }
    
    protected function _renderCLI($array_key = NULL) {
        return $this->renderArrayKey($array_key) . $this->type . ' '. CLIColors::getColoredString ($this->getValue(), $this->getColor('cli')) . "\n";
    }
    
    protected function renderArrayKey($key) {
        
        if (is_null($key)) return NULL;
        else return "[$key]: ";
    }
    
    protected function renderTreeSwitcher($label, $array_key = NULL) {
        $tree_id = \Ladybug\Dumper::getTreeId();
        $result = '<label for="tree_'.$this->type.'_'.$tree_id.'">';
            $result .= $this->renderArrayKey($array_key);
            $result .= '<strong><em>'.$label.'</em></strong>';
        $result .= '</label>';
        
        $result .= '<input type="checkbox" id="tree_'.$this->type.'_'.$tree_id.'" />';
        
        return $result;
    }
    
    protected function getIncludeClass($name, $type = 'object') {
        $class = '';
        $path_array = explode('\\', $name);
        $path_number = count($path_array);
        $class_name = '';
        
        for ($i=0;$i<$path_number;$i++) {
            $class_name .= str_replace(' ', '', ucwords($path_array[$i]));
            if (($i+1) < $path_number) $class_name .= '\\';
        }
        
        
        if ($type == 'object') $class = 'Ladybug\\Extension\\Object\\'.$class_name;
        elseif ($type == 'resource') $class = 'Ladybug\\Extension\\Resource\\'.$class_name;
        
        return $class;
    }
    
    protected function indentCLI($increment = 0) {
        //$char = CLIColors::getColoredString(' · ', 'dark_gray');
        
        $char1 = CLIColors::getColoredString('   ', 'dark_gray');
        $char2 = CLIColors::getColoredString(' | ', 'dark_gray');
        
        $result = '';
        for ($i=0;$i<($this->level + $increment);$i++) {
            if ($i==0) $result .= $char1;
            else $result .= $char2;
        }
        return $result;
    }
    
}