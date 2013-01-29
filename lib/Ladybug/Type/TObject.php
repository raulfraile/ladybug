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

use Ladybug\Options;
use Ladybug\CLIColors;

class TObject extends TBase
{

    const TYPE_ID = 'object';

    protected $class_name;
    protected $class_constants;
    protected $object_properties;
    protected $class_static_properties;
    protected $class_methods;
    protected $object_custom_data;
    protected $class_file;
    protected $class_interfaces;
    protected $class_namespace;
    protected $class_parent;
    protected $tostring;

    protected $is_leaf;

    protected $inspect_custom_data;
    protected $is_custom_data;

    public function __construct($var, $level, Options $options)
    {
        parent::__construct(self::TYPE_ID, $var, $level, $options);

        $this->inspect_custom_data = true;

        $this->class_name = get_class($var);

        $this->tostring = null;

        if ($this->level < $this->options->getOption('object.max_nesting_level')) {
            $this->is_leaf = false;

            $reflection_class = new \ReflectionClass($this->class_name);

            // class info
            if ($this->options->getOption('object.show_classinfo')) {
                $this->class_file = $reflection_class->getFileName();
                if (empty($this->class_file)) $this->class_file = 'built-in';
                $this->class_interfaces = implode(', ', $reflection_class->getInterfaceNames());
                $this->class_namespace = $reflection_class->getNamespaceName();
                $class_parent_obj = $reflection_class->getParentClass();
                if ($class_parent_obj) $this->class_parent = $class_parent_obj->getName();
                else $this->class_parent = '';

                unset($class_parent_obj); $class_parent_obj = NULL;
            }

            if ($this->options->getOption('object.show_data')) {
                // is there a class to show the object data?
                $include_class = $this->getIncludeClass($this->class_name, 'object');

                if (class_exists($include_class)) {
                    $custom_dumper = new $include_class($var);
                    $this->object_custom_data = $custom_dumper->dump($var);
                    $this->is_custom_data = TRUE;

                    if (is_array($this->object_custom_data)) $this->inspect_custom_data = $custom_dumper->getInspect();
                    else $this->inspect_custom_data = FALSE;
                } else {
                    $this->object_custom_data = (array) $var;
                    $this->is_custom_data = FALSE;
                    $this->inspect_custom_data = TRUE;
                }

                // Custom/array-cast data & name normalization
                if (!empty($this->object_custom_data) && is_array($this->object_custom_data)) {
                    foreach ($this->object_custom_data as &$c) {
                        $c = TFactory::factory($c, $this->level, $options);
                    }
                }
            }

            // Class constants
            if ($this->options->getOption('object.show_constants')) {
                $this->class_constants = $reflection_class->getConstants();
                if (!empty($this->class_constants)) {
                    foreach ($this->class_constants as &$c) {
                        $c = TFactory::factory($c, $this->level, $options);
                    }
                }
            }

            // Object properties
            if ($this->options->getOption('object.show_properties')) {
                $object_properties = $reflection_class->getProperties();
                $this->object_properties = array();
                if (!empty($object_properties)) {
                    foreach ($object_properties as $property) {
                        if ($property->isPublic()) {
                            $property_value = $property->getValue($this->value);
                            $this->object_properties[$property->getName()] = TFactory::factory($property_value, $this->level, $options);
                        }
                    }
                }
            }

            // Class methods
            if ($this->options->getOption('object.show_methods')) {
                $this->class_methods = array();
                $class_methods = $reflection_class->getMethods();
                if (!empty($class_methods)) {
                    foreach ($class_methods as $k=>$v) {
                        $method = $reflection_class->getMethod($v->name);

                        if ($method->getName() == '__toString') $this->tostring = $var->__toString();

                        $method_syntax = '';

                        if ($method->isStatic()) $method_syntax .= 'static ';
                        elseif ($method->isPublic()) $method_syntax .= 'public ';
                        elseif ($method->isProtected()) $method_syntax .= 'protected ';
                        elseif ($method->isPrivate()) $method_syntax .= 'private ';

                        $method_syntax .= $method->getName();

                        $method_parameters = $method->getParameters();
                        $method_syntax .= '(';
                        $method_parameters_result = array();
                        foreach ($method_parameters as $parameter) {
                            $parameter_result = '';

                            $class = $parameter->getClass();
                            if ($class instanceof \ReflectionClass) {
                                $parameter_result .= $class->getName().' ';
                            }

                            if ($parameter->isOptional()) $parameter_result .= '[';

                            if ($parameter->isPassedByReference()) $parameter_result .= '&';
                            $parameter_result .= '$' . $parameter->getName();

                            $default = NULL;
                            if ($parameter->isDefaultValueAvailable()) {
                                $default = $parameter->getDefaultValue();

                                if($default === null) $default = 'NULL';
                                elseif(is_bool($default)) $default = $default ? 'TRUE' : 'FALSE';
                                elseif(is_string($default)) $default = '"' . htmlentities($default, ENT_COMPAT) . '"';
                                elseif(is_array($default)) $default = 'Array';

                                $parameter_result .= ' = ' . $default;
                            }

                            if ($parameter->isOptional()) $parameter_result .= ']';

                            $method_parameters_result[] = $parameter_result;
                        }

                        $method_syntax .= implode(', ', $method_parameters_result);
                        $method_syntax .= ')';

                        $this->class_methods[] = $method_syntax;
                    }

                    sort($this->class_methods, SORT_STRING);
                }
            }
        } else $this->is_leaf = TRUE;
    }

    public function _renderHTML($array_key = NULL, $escape = false)
    {
        $label = $this->type . '('.$this->class_name . ')';

        if (!is_null($this->tostring)) $label .= '<a class="tostring" href="javascript:void(0)" title="'.htmlentities($this->tostring).'"></a>';
        $result = $this->renderTreeSwitcher($label, $array_key);

        if (!$this->is_leaf) {
            $result .= '<ol>';

            if (!empty($this->object_custom_data)) {
                $result .= '<li>' . $this->renderTreeSwitcher('Data') . '<ol>';

                if (is_array($this->object_custom_data)) {
                    foreach ($this->object_custom_data as $k=>&$v) {

                        if ($this->inspect_custom_data) $result .= '<li>'.$v->render($k).'</li>';
                        else $result .= '<li>' . $this->renderArrayKey($k) . $v->getValue().'</li>';
                    }
                } else $result .= '<li>'.$this->object_custom_data.'</li>';

                $result .= '</ol></li>';

            }

            // class info
            if (!empty($this->class_file)) {
                $result .= '<li>' . $this->renderTreeSwitcher('Class info') . '<ol>';
                if (!empty($this->class_file)) $result .= '<li>Filename: '.$this->class_file.'</li>';
                if (!empty($this->class_interfaces)) $result .= '<li>Interfaces: '.$this->class_interfaces.'</li>';
                if (!empty($this->class_namespace)) $result .= '<li>Namespace: '.$this->class_namespace.'</li>';
                if (!empty($this->class_parent)) $result .= '<li>Parent: '.$this->class_parent.'</li>';
                $result .= '</ol></li>';
            }

            // constants
            if (!empty($this->class_constants)) {
                $result .= '<li>' . $this->renderTreeSwitcher('Constants') . '<ol>';
                foreach ($this->class_constants as $k=>$v) {
                    $result .= '<li>'.$v->render($k).'</li>';
                }
                $result .= '</ol></li>';
            }

            // properties
            if (!empty($this->object_properties)) {
                $result .= '<li>' . $this->renderTreeSwitcher('Public properties') . '<ol>';
                foreach ($this->object_properties as $k=>$v) {
                    $result .= '<li>'.$v->render($k).'</li>';
                }
                $result .= '</ol></li>';
            }

            // static properties
            if (!empty($this->class_static_properties)) {
                $result .= '<li>' . $this->renderTreeSwitcher('Static properties') . '<ol>';
                foreach ($this->class_static_properties as $k=>$v) {
                    $result .= '<li>'.$v->render($k).'</li>';
                }
                $result .= '</ol></li>';
            }

            // class methods
            if (!empty($this->class_methods)) {
                $result .= '<li>' . $this->renderTreeSwitcher('Methods') . '<ol>';
                foreach ($this->class_methods as $v) {
                    $result .= '<li>'.$v.'</li>';
                }
                $result .= '</ol></li>';
            }

            $result .= '</ol>';
        }

        return $result;

    }

    public function _renderCLI($array_key = NULL)
    {
        $label = $this->type . '('.$this->class_name . ')';
        $result = $this->renderArrayKey($array_key) . CLIColors::getColoredString($label, 'yellow');

        if (!$this->is_leaf) {

            $result .=  "\n";

            if (!empty($this->object_custom_data)) {
                $result .= $this->indentCLI() . CLIColors::getColoredString('Data', NULL, 'magenta') . "\n";

                if (is_array($this->object_custom_data)) {
                    foreach ($this->object_custom_data as $k=>&$v) {
                        $result .= $this->indentCLI() .  $v->render($k, 'cli');
                    }
                } else $result .= $this->indentCLI() . $this->object_custom_data."\n";

            }

            // class info
            if (!empty($this->class_file)) {
                $result .= $this->indentCLI() . CLIColors::getColoredString('Class info', NULL, 'magenta') . "\n";
                if (!empty($this->class_file)) $result .= $this->indentCLI() . 'Filename: '.$this->class_file."\n";
                if (!empty($this->class_interfaces)) $result .= $this->indentCLI() . 'Interfaces: '.$this->class_interfaces."\n";
                if (!empty($this->class_namespace)) $result .= $this->indentCLI() . 'Namespace: '.$this->class_namespace."\n";
                if (!empty($this->class_parent)) $result .= $this->indentCLI() . 'Parent: '.$this->class_parent."\n";
            }

            // constants
            $result .= $this->_renderListCLI($this->class_constants, 'Constants');

            // properties
            $result .= $this->_renderListCLI($this->object_properties, 'Public properties');

            // static properties
            $result .= $this->_renderListCLI($this->class_static_properties, 'Static properties');

            // methods
            $result .= $this->_renderListCLI($this->class_methods, 'Methods');

        } else $result .= "\n";

        return $result;

    }

    private function _renderListCLI(&$list, $title)
    {
        $result = '';

        if (!empty($list)) {
            $result .= $this->indentCLI() . CLIColors::getColoredString($title, NULL, 'magenta') . "\n";
            foreach ($list as $k=>$v) {
                $result .= $this->indentCLI();

                if (is_string($v)) $result .= $v;
                else $result .= $v->render($k, 'cli');

                $result .= "\n";
            }
        }

        // remove extra "\n"
        $result = preg_replace('/\n+/', "\n", $result);

        return $result;
    }

    public function _renderTXT($array_key = NULL)
    {
        $label = $this->type . '('.$this->class_name . ')';
        $result = $this->renderArrayKey($array_key) . $label;

        if (!$this->is_leaf) {

            $result .=  "\n";

            if (!empty($this->object_custom_data)) {
                $result .= $this->indentTXT() . 'Data' . "\n";

                if (is_array($this->object_custom_data)) {
                    foreach ($this->object_custom_data as $k=>&$v) {
                        $result .= $this->indentTXT() .  $v->render($k, 'txt');
                    }
                } else $result .= $this->indentTXT() . $this->object_custom_data."\n";

            }

            // class info
            if (!empty($this->class_file)) {
                $result .= $this->indentTXT() . 'Class info' . "\n";
                if (!empty($this->class_file)) $result .= $this->indentTXT() . 'Filename: '.$this->class_file."\n";
                if (!empty($this->class_interfaces)) $result .= $this->indentTXT() . 'Interfaces: '.$this->class_interfaces."\n";
                if (!empty($this->class_namespace)) $result .= $this->indentTXT() . 'Namespace: '.$this->class_namespace."\n";
                if (!empty($this->class_parent)) $result .= $this->indentTXT() . 'Parent: '.$this->class_parent."\n";
            }

            // constants
            $result .= $this->_renderListTXT($this->class_constants, 'Constants');

            // properties
            $result .= $this->_renderListTXT($this->object_properties, 'Public properties');

            // static properties
            $result .= $this->_renderListTXT($this->class_static_properties, 'Static properties');

            // methods
            $result .= $this->_renderListTXT($this->class_methods, 'Methods');

        } else $result .= "\n";

        return $result;

    }

    private function _renderListTXT(&$list, $title)
    {
        $result = '';

        if (!empty($list)) {
            $result .= $this->indentTXT() . $title . "\n";
            foreach ($list as $k=>$v) {
                $result .= '  '.$this->indentTXT();

                if (is_string($v)) $result .= $v;
                else $result .= $v->render($k, 'txt');

                $result .= "\n";
            }
        }

        // remove extra "\n"
        $result = preg_replace('/\n+/', "\n", $result);

        return $result;
    }
    public function export()
    {
        $value = array();

        // Class info
        $value['class_info'] = array();
        if (!empty($this->class_file)) $value['class_info']['filename'] = $this->class_file;
        if (!empty($this->class_interfaces)) $value['class_info']['interfaces'] = $this->class_interfaces."\n";
        if (!empty($this->class_namespace)) $value['class_info']['namespace'] = $this->class_namespace."\n";
        if (!empty($this->class_parent)) $value['class_info']['parent'] = $this->class_parent."\n";

        // Constants
        $value['constants'] = array();
        foreach ($this->class_constants as $k=>$v) {
            if (is_string($v)) $value['constants'][$k] = $v;
            else $value['constants'][$k] = $v->export();
        }

        // Properties
        $value['public_properties'] = array();
        foreach ($this->object_properties as $k=>$v) {
            if (is_string($v)) $value['public_properties'][$k] = $v;
            else $value['public_properties'][$k] = $v->export();
        }

        // Static properties
        /*$value['static_properties'] = array();
        foreach ($this->class_static_properties as $k=>$v) {
            if (is_string($v)) $value['static_properties'][$k] = $v;
            else $value['static_properties'][$k] = $v->export();
        }*/

        // Methods
        $value['methods'] = array();
        foreach ($this->class_methods as $k=>$v) {
            if (is_string($v)) $value['methods'][$k] = $v;
            else $value['methods'][$k] = $v->export();
        }

        $return = array(
            'type' => $this->type . '(' . $this->class_name . ')',
            'value' => $value
        );

        return $return;
    }
}
