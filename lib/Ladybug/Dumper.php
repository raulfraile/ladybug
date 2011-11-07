<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

class Dumper {
    
    const COLOR_STRING = '#080';
    const COLOR_INT = '#800';
    const COLOR_FLOAT = '#800';
    const COLOR_BOOL = '#008';
    
    const CHAR_TAB = '    ';
    const CHAR_NEWLINE = "\n";
    
    const EXTENSIONS_FOLDER = 'Extension';
    const OBJECTS_FOLDER = 'Object';
    const RESOURCES_FOLDER = 'Resource';
    
    public static $depth = 0;
    
    private static $instance = null;
    
    private function __construct() {}
    
    /**
     * Singleton method
     * @return Get singleton instance
     */
    public static function getInstance() {
        return (self::$instance !== null) ? self::$instance : (self::$instance = new Dumper()); 
    }
    
    /**
     * Dump one or more variables
     * @param vars one or more variables to dump
     */
    public function dump(/*$var1 [, $var2...$varN]*/) {
        $args = func_get_args();
        $num_args = func_num_args();
        
        $result = '';
        
        foreach ($args as $var) {
            if($var === null) $result .= $this->dump_null();
            elseif(is_bool($var)) $result .= $this->dump_bool($var);
            elseif(is_string($var)) $result .= $this->dump_string($var);
            elseif(is_int($var)) $result .= $this->dump_int($var);
            elseif(is_float($var)) $result .= $this->dump_float($var);
            elseif(is_array($var)) $result .= $this->dump_array($var);
            elseif (is_object($var)) $result .= $this->dump_object($var);
            else if(is_resource($var)) $result .= $this->dump_resource($var);
            else $result .= 'unknown';
            
            if ($num_args > 1) $result .= self::CHAR_NEWLINE;
        }

        if (self::$depth == 0) {
            $result = '<pre>' . $result . '</pre>';
            return $result;
        }
        else return $result;
    }
    
    /**
     * Write depth indentation
     * @return string
     */
    public function writeDepth() {
        $result = '';
        for ($i=0;$i<self::$depth;$i++) $result .= self::CHAR_TAB;
        
        return $result;
    }
    
    /**
     * Write var type in HTML
     * @param string $type var type
     * @return string
     */
    public function write_type($type) {
        return '<strong><em>'.$type.'</em></strong>';
    }
    
    /**
     * Write var value in HTML
     * @param string $value var value
     * @param string $color HTML color
     * @return string
     */
    public function write_value($value, $color) {
        return '<span style="color:'.$color.'">'.$value.'</span>';
    }
    
    /**
     * Write a complete type/value line in HTML
     * @param string $type var type
     * @param string $value[optional] var value
     * @param string $color[optional] HTML color
     * @return string
     */
    public function write_all($type, $value = NULL, $color = NULL) {
        $result = $this->write_type($type);
        
        if (!is_null($value) && !is_null($color)) $result .= ' ' . $this->write_value($value, $color);
        
        return  $result;
    }
    
    /**
     * Get information of a null variable
     * @param mixed $var null variable
     * @return string
     */
    private function dump_null() {
        return $this->write_all('NULL');
    }
    
    /**
     * Get information of a single bool variable
     * @param bool $var variable
     * @return string
     */
    private function dump_bool($var) {
        $type = 'bool';
        $value = $var ? 'TRUE' : 'FALSE';
        
        return $this->write_all($type, $value, self::COLOR_BOOL);
    }
    
    /**
     * Get information of a single string
     * @param string $var string variable
     * @return string
     */
    private function dump_string($var) {
        $type = 'string('.strlen($var).')';
        $value = '"' . $var . '"';
        
        return $this->write_all($type, $value, self::COLOR_STRING);
    }
    
    /**
     * Get information of a single integer variable
     * @param int $var integer variable
     * @return string
     */
    private function dump_int($var) {
        $type = 'int';
        $value = $var;
        
        return $this->write_all($type, $value, self::COLOR_INT);
    }
    
    /**
     * Get information of a single floating point variable
     * @param float $var float variable
     * @return string
     */
    private function dump_float($var) {
        $type = 'float';
        $value = $var;
        
        return $this->write_all($type, $value, self::COLOR_FLOAT);
    }
    
    /**
     * Get information of an array
     * @param array $var array
     * @return string
     */
    private function dump_array($var) {
        $result = $this->write_all('array') . " [";
        $array_count = count($var);
        
        if ($array_count > 0) $result .= self::CHAR_NEWLINE;
        
        self::$depth++;
        
        $i = 0;
        foreach($var as $k => $v) {
            $result .= $this->writeDepth() . '['.$k.'] => '.$this->dump($v);
            
            $i++;
                
            if ($i <= $array_count) $result .= self::CHAR_NEWLINE;
	}
        
        self::$depth--;
        
        $result .= $this->writeDepth()."]";

	return $result;
    }
    
    /**
     * Get information of an object using reflection
     * @param object $var object
     * @return string
     */
    private function dump_object($var) {
        $class_name = get_class($var);
        
        $reflection_class = new \ReflectionClass($class_name); 
        
        $data = (array)$var;
        $object_constants = $reflection_class->getConstants();
        $object_properties = $reflection_class->getProperties();
        $object_static_properties = $reflection_class->getStaticProperties();
        $object_methods = $reflection_class->getMethods();
        
        $class_file = $reflection_class->getFileName();
        $class_interfaces = implode(', ', $reflection_class->getInterfaceNames());
        $class_namespace = $reflection_class->getNamespaceName();
        $class_parent_obj = $reflection_class->getParentClass();
        if ($class_parent_obj) $class_parent = $class_parent_obj->getName();
        else $class_parent = '';
        
        $type = 'object('.$class_name.')';
        
        $result = $this->write_all($type)." [";
        
        // is there a class to show the object info?
        $include_class = $this->getIncludeClass($class_name, 'object');
        
        if (class_exists($include_class)) {
            $custom_dumper = new $include_class($this);
            self::$depth+=2;
            $data = $custom_dumper->dump($var);
            self::$depth-=2;
        }
        
        if (!empty($data)
                || !empty($object_constants)
                || !empty($object_properties)
                || !empty($object_static_properties)
                || !empty($object_methods)
                ) $result .= self::CHAR_NEWLINE;
        
        self::$depth++;
        
        // info about the class
        if (!empty($class_file)) {
            $result .= $this->writeDepth(). "[class] => [\n";
            
                self::$depth++;
                $result .= $this->writeDepth() . '[file] => '.$class_file.self::CHAR_NEWLINE;
                if (!empty($class_interfaces)) $result .= $this->writeDepth() . '[interfaces] => '.$class_interfaces.self::CHAR_NEWLINE;
                if (!empty($class_namespace)) $result .= $this->writeDepth() . '[namespace] => '.$class_namespace.self::CHAR_NEWLINE;
                if (!empty($class_parent)) $result .= $this->writeDepth() . '[parent] => '.$class_parent.self::CHAR_NEWLINE;
                
                self::$depth--;
            
            $result .= $this->writeDepth()."]\n";
        }
        
        if (!empty($data)) {
            $result .= $this->writeDepth(). "[data] => [\n";
            if (is_array($data)) {
                self::$depth++;
                foreach($data as $k=>&$v) {
                    $result .= $this->writeDepth() . '['.$k.'] => '.$this->dump($v).self::CHAR_NEWLINE;
                }
                self::$depth--;
            }
            else $result .= $data;
            $result .= $this->writeDepth()."]\n";
        }
        
        
        if (!empty($object_constants)) {
            $result .= $this->writeDepth() . "[constants] => [\n";
            self::$depth++;
            foreach($object_constants as $k=>&$v) {
                $result .= $this->writeDepth() . '['.$k.'] => '.$this->dump($v).self::CHAR_NEWLINE;
            }
            self::$depth--;
            $result .= $this->writeDepth()."]\n";
        }
        
	if (!empty($object_properties)) {
            $result .= $this->writeDepth() . "[properties] => [\n";
            self::$depth++;
            foreach($object_properties as $property) {
                if ($property->isPublic()) $result .= $this->writeDepth() . '['.$property->getName().'] => '.$this->dump($property->getValue($var)).self::CHAR_NEWLINE;
            }
            self::$depth--;
            $result .= $this->writeDepth()."]\n";
        }
        
        if (!empty($object_methods)) {
            $result .= $this->writeDepth()."[methods] => [\n";
            self::$depth++;
            foreach($object_methods as $k=>&$v) {
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
                
                $result .= $this->writeDepth() .$method_syntax.self::CHAR_NEWLINE;
            }
            self::$depth--;
            $result .= $this->writeDepth() ."]\n";
        }
        
        self::$depth--;
        
        $result .= $this->writeDepth() ."]";
        
        return $result;
    }
    
    private function dump_resource($var) {
        $type = 'resource';
        $value = '';
        $resource_type = get_resource_type($var);
        
        self::$depth++;
        
        if ($resource_type == 'stream') {
            $stream_vars = stream_get_meta_data($var);
            
            // prevent unix sistems getting stream in files
            if (isset($stream_vars['stream_type']) && $stream_vars['stream_type'] == 'STDIO') $resource_type = 'file';

        }
        
        // is there a class to show the resource info?
        $include_class = $this->getIncludeClass($resource_type, 'resource');
        if (class_exists($include_class)) {
            $custom_dumper = new $include_class($this);
            $value = $custom_dumper->dump($var);
        }
        
            
        self::$depth--;
        
        $type .= "($resource_type)";
        
        $result = $this->write_all($type) . " [";
        if (!empty($value)) $result .= self::CHAR_NEWLINE;
        $result .= $value;
        
        if (!empty($value)) $result .= $this->writeDepth();
        
        $result .= "]";
        
        return $result;
    }
    
    public function formatSize($size, $unit = NULL) {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        
        $result = '';
        
        if ($size < $kb) $result = $size . ' bytes';
        elseif ($size < $mb) $result = number_format($size/$kb, 2) . ' Kb';
        elseif ($size < $gb) $result = number_format($size/$mb, 2) . ' Mb';
        else $result = number_format($size/$gb, 2) . ' Gb';
        
        return $result;
    }    
    
    private function getIncludeClass($name, $type = 'object') {
        $class = '';
        
        if ($type == 'object') $class = 'Ladybug\\Extension\\Object\\'.str_replace(' ', '', ucwords(strtolower($name)));
        elseif ($type == 'resource') $class = 'Ladybug\\Extension\\Resource\\'.str_replace(' ', '', ucwords(strtolower($name)));
        
        return $class;
    }
    
}

