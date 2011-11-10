<?php

namespace Ladybug;

class Variable {
    const COLOR_STRING = '#080';
    const COLOR_INT = '#800';
    const COLOR_FLOAT = '#800';
    const COLOR_BOOL = '#008';
    
    protected $type;
    protected $value;
    
    protected function __construct($type, $value = NULL) {
        $this->type = $type;
        $this->value = $value;
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
}