<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Type/TObject variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Variable;

class TObject extends Variable {
    
    protected $class_name;
    protected $object_constants;
    //protected $object_properties;
    protected $object_properties_clean;
    //protected $object_static_properties;
    protected $object_static_properties_clean;
    protected $object_methods;
    protected $object_custom_data;
    protected $class_file;
    protected $class_interfaces;
    protected $class_namespace;
    protected $class_parent;
    
    private $level;
    
    public function __construct($var, $level = 0) {
        $this->type = 'object';
        $this->value = $var;
        $this->level = $level+1;
        
        $this->class_name = get_class($var);
       
        if ($this->level < \Ladybug\Dumper::MAX_NESTING_LEVEL_OBJECTS) {
            $reflection_class = new \ReflectionClass($this->class_name); 

            $this->object_custom_data = (array)$var;
            $this->object_constants = $reflection_class->getConstants();
            $object_properties = $reflection_class->getProperties();
            $this->object_properties_clean = array();
            //$object_static_properties = $reflection_class->getStaticProperties();
            //$this->object_static_properties_clean = array();
            $this->object_methods = $reflection_class->getMethods();

            $this->class_file = $reflection_class->getFileName();
            if (empty($this->class_file)) $this->class_file = 'built-in';
            $this->class_interfaces = implode(', ', $reflection_class->getInterfaceNames());
            $this->class_namespace = $reflection_class->getNamespaceName();
            $class_parent_obj = $reflection_class->getParentClass();
            if ($class_parent_obj) $this->class_parent = $class_parent_obj->getName();
            else $this->class_parent = '';

            unset($class_parent_obj);$class_parent_obj = NULL;
            unset($reflection_class);$reflection_class = NULL;

            // is there a class to show the object info?
            $include_class = $this->getIncludeClass($this->class_name, 'object');

            if (class_exists($include_class)) {
                $custom_dumper = new $include_class($var);
                $this->object_custom_data = $custom_dumper->dump($var);
            }

            // format data
            if (!empty($this->object_custom_data) && is_array($this->object_custom_data)) {
                foreach ($this->object_custom_data as &$c) {
                    $c = TFactory::factory($c, $this->level);
                }
            }

            if (!empty($this->object_constants)) {
                foreach ($this->object_constants as &$c) {
                    $c = TFactory::factory($c, $this->level);
                }
            }

            if (!empty($object_properties)) {
                foreach($object_properties as $property) {
                    if ($property->isPublic()) {
                        $property_value = $property->getValue($this->value);
                        $this->object_properties_clean[$property->getName()] = TFactory::factory($property_value, $this->level);
                    }
                }
            }

            /*if (!empty($this->object_static_properties)) {
                foreach($this->object_static_properties as $property) {
                    if ($property->isPublic()) {
                        $property_value = $property->getValue($this->value);
                        $this->object_static_properties_clean[$property->getName()] = TFactory::factory($property_value, $this->level);
                    }
                }
            }*/
        }
    }
    
    public function render($array_key = NULL) {
        $label = $this->type . '('.$this->class_name . ')';
        $result = $this->renderTreeSwitcher($label, $array_key) . '<ol>';
        
        
        if (!empty($this->object_custom_data)) {
            $result .= '<li>' . $this->renderTreeSwitcher('Data') . '<ol>';
            
            if (is_array($this->object_custom_data)) {
                foreach($this->object_custom_data as $k=>&$v) {
                    $result .= '<li>'.$v->render($k).'</li>';
                }
            }
            else $result .= '<li>'.$this->object_custom_data.'</li>';
            
            $result .= '</ol></li>';
            
        }
        
        // class info
        if (!empty($this->class_file)) {
            $result .= '<li>' . $this->renderTreeSwitcher('Class info') . '<ol>';
            if (!empty($this->class_file)) $result .= '<li>file: '.$this->class_file.'</li>';
            if (!empty($this->class_interfaces)) $result .= '<li>interfaces: '.$this->class_interfaces.'</li>';
            if (!empty($this->class_namespace)) $result .= '<li>namespace: '.$this->class_namespace.'</li>';
            if (!empty($this->class_parent)) $result .= '<li>parent: '.$this->class_parent.'</li>';        
            $result .= '</ol></li>';       
        }
                
        // constants
        if (!empty($this->object_constants)) {
            $result .= '<li>' . $this->renderTreeSwitcher('Constants') . '<ol>';
            foreach($this->object_constants as $k=>&$v) {
                $result .= '<li>'.$v->render($k).'</li>';
            }
            $result .= '</ol></li>';
        }
        
        // properties
        if (!empty($this->object_properties_clean)) {
            $result .= '<li>' . $this->renderTreeSwitcher('Public properties') . '<ol>';
            foreach($this->object_properties_clean as $k=>$v) {
                $result .= '<li>'.$v->render($k).'</li>';
            }
            $result .= '</ol></li>';
        }
        
        // static properties
        if (!empty($this->object_static_properties_clean)) {
            $result .= '<li>' . $this->renderTreeSwitcher('Static properties') . '<ol>';
            foreach($this->object_static_properties_clean as $k=>$v) {
                $result .= '<li>'.$v->render($k).'</li>';
            }
            $result .= '</ol></li>';
        }
        
        // methods
        if (!empty($this->object_methods)) {
            $result .= '<li>' . $this->renderTreeSwitcher('Methods') . '<ol>';
            
            $reflection_class = new \ReflectionClass($this->class_name);
            foreach($this->object_methods as $k=>&$v) {
                $method = $reflection_class->getMethod($v->name);
                $method_syntax = '';
                
                if ($method->isPublic()) $method_syntax .= '+ ';
                elseif ($method->isProtected()) $method_syntax .= '# ';
                elseif ($method->isPrivate()) $method_syntax .= '- ';
                
                $method_syntax .= $method->getName();
                
                $method_parameters = $method->getParameters();
                $method_syntax .= '(';
                $method_parameters_result = array();
                foreach ($method_parameters as $parameter) {
                    $parameter_result = '';
                    if ($parameter->isOptional()) $parameter_result .= '[';
                    
                    if ($parameter->isPassedByReference()) $parameter_result .= '&';
                    $parameter_result .= '$' . $parameter->getName();
                    
                    if ($parameter->isOptional()) $parameter_result .= ']';
                    
                    $method_parameters_result[] = $parameter_result; 
                }
                
                $method_syntax .= implode(', ', $method_parameters_result);
                $method_syntax .= ')';
                
                $result .= '<li>'.$method_syntax.'</li>';
            }
            
            $result .= '</ol></li>';
        }
        
        $result .= '</ol>';
        
        return $result;
        
    }
}