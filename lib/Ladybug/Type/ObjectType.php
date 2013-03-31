<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/ObjectType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;
use Pimple;
use Ladybug\Extension\ExtensionInterface;

class ObjectType extends BaseType
{

    const TYPE_ID = 'object';

    protected $className = null;
    protected $classConstants = array();
    protected $objectProperties = array();
    protected $classStaticProperties = array();
    protected $classMethods = array();
    protected $objectCustomData = null;
    protected $classFile = null;
    protected $classInterfaces = array();
    protected $classNamespace = null;
    protected $classParent = null;
    protected $toString = null;

    protected $isLeaf;

    protected $inspect_custom_data;
    protected $isCustomData;

    public function __construct($var, $level, Pimple $container, $key = null)
    {
        parent::__construct(self::TYPE_ID, $var, $level, $container, $key);

        $this->inspect_custom_data = true;

        $this->className = get_class($var);

        $this->toString = (method_exists($var, '__toString')) ? $var->__toString() : null;

        if ($this->level < $this->getOption('object.max_nesting_level')) {
            $this->isLeaf = false;

            $reflection_class = new \ReflectionClass($this->className);

            // class info
            if ($this->getOption('object.show_classinfo')) {
                $this->classFile = $reflection_class->getFileName();
                if (empty($this->classFile)) $this->classFile = 'built-in';
                $this->classInterfaces = implode(', ', $reflection_class->getInterfaceNames());
                $this->classNamespace = $reflection_class->getNamespaceName();
                $class_parent_obj = $reflection_class->getParentClass();
                if ($class_parent_obj) $this->classParent = $class_parent_obj->getName();
                else $this->classParent = '';

                unset($class_parent_obj); $class_parent_obj = NULL;
            }

            if ($this->getOption('object.show_data')) {
                // is there a class to show the object data?
                $include_class = $this->getIncludeClass($this->className, 'object');

                if (class_exists($include_class)) {

                    /** @var $customDumper ExtensionInterface */
                    $customDumper = new $include_class($var, $this->level, $this->container);
                    $data = $customDumper->getData($var);
                    $this->objectCustomData = FactoryType::factory($data, $this->level, $this->container);

                    //$custom_dumper = new $include_class($var, $this->container);
                    //$this->objectCustomData = FactoryType::factory(array($custom_dumper->getData($var)), $this->container);
                    $this->isCustomData = TRUE;

                    if (is_array($this->objectCustomData)) $this->inspect_custom_data = $customDumper->getInspect();
                    else $this->inspect_custom_data = FALSE;
                } else {
                    $data = (array) $var;

                    // unmangle private and protected
                    $this->objectCustomData = array();
                    foreach ($data as $key => $item) {

                        $type = FactoryType::factory($item, $this->level, $this->container);
$type=$item;
                        if (0 === strpos($key, "\0*\0")) {
                            $this->objectCustomData['protected ' . substr($key, 3)] = $type;
                        } elseif (0 === strpos($key, "\0" . $this->className . "\0")) {
                            $this->objectCustomData['private ' . substr($key, 2 + strlen($this->className))] = $type;
                        } else {
                            $this->objectCustomData['public ' . $key] = $type;
                        }
                    }

                    $this->isCustomData = FALSE;
                    $this->inspect_custom_data = TRUE;
                }

                // Custom/array-cast data & name normalization
                if (!empty($this->objectCustomData) && is_array($this->objectCustomData)) {
                    foreach ($this->objectCustomData as &$c) {
                        $c = FactoryType::factory($c, $this->level, $this->container);
                    }
                }
            }

            // Class constants
            if ($this->getOption('object.show_constants')) {
                $this->classConstants = $reflection_class->getConstants();
                if (!empty($this->classConstants)) {
                    foreach ($this->classConstants as &$c) {
                        $c = FactoryType::factory($c, $this->level, $this->container);
                    }
                }
            }

            // Object properties
            if ($this->getOption('object.show_properties')) {
                $object_properties = $reflection_class->getProperties();
                $this->objectProperties = array();
                if (!empty($object_properties)) {
                    foreach ($object_properties as $property) {
                        if ($property->isPublic()) {
                            $property_value = $property->getValue($this->value);
                            $this->object_properties[$property->getName()] = FactoryType::factory($property_value, $this->level, $this->container);
                        }
                    }
                }
            }

            // Class methods
            if ($this->getOption('object.show_methods')) {
                $this->classMethods = array();
                $class_methods = $reflection_class->getMethods();
                if (!empty($class_methods)) {
                    foreach ($class_methods as $k=>$v) {
                        $method = $reflection_class->getMethod($v->name);

                        //if ($method->getName() == '__toString') $this->tostring = $var->__toString();

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

                        $this->classMethods[] = $method_syntax;
                    }

                    sort($this->classMethods, SORT_STRING);
                }
            }
        } else $this->isLeaf = TRUE;


    }

    public function export()
    {
        $value = array();

        // Class info
        $value['class_info'] = array();
        if (!empty($this->classFile)) $value['class_info']['filename'] = $this->classFile;
        if (!empty($this->classInterfaces)) $value['class_info']['interfaces'] = $this->classInterfaces."\n";
        if (!empty($this->classNamespace)) $value['class_info']['namespace'] = $this->classNamespace."\n";
        if (!empty($this->classParent)) $value['class_info']['parent'] = $this->classParent."\n";

        // Constants
        $value['constants'] = array();
        foreach ($this->classConstants as $k=>$v) {
            if (is_string($v)) $value['constants'][$k] = $v;
            else $value['constants'][$k] = $v->export();
        }

        // Properties
        $value['public_properties'] = array();
        foreach ($this->objectProperties as $k=>$v) {
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
        foreach ($this->classMethods as $k=>$v) {
            if (is_string($v)) $value['methods'][$k] = $v;
            else $value['methods'][$k] = $v->export();
        }

        $return = array(
            'type' => $this->type . '(' . $this->className . ')',
            'value' => $value
        );

        return $return;
    }

    public function setClassConstants($classConstants)
    {
        $this->classConstants = $classConstants;
    }

    public function getClassConstants()
    {
        return $this->classConstants;
    }

    public function setClassFile($classFile)
    {
        $this->classFile = $classFile;
    }

    public function getClassFile()
    {
        return $this->classFile;
    }

    public function setClassInterfaces($classInterfaces)
    {
        $this->classInterfaces = $classInterfaces;
    }

    public function getClassInterfaces()
    {
        return $this->classInterfaces;
    }

    public function setClassMethods($classMethods)
    {
        $this->classMethods = $classMethods;
    }

    public function getClassMethods()
    {
        return $this->classMethods;
    }

    public function setClassName($className)
    {
        $this->className = $className;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function setClassNamespace($classNamespace)
    {
        $this->classNamespace = $classNamespace;
    }

    public function getClassNamespace()
    {
        return $this->classNamespace;
    }

    public function setClassParent($classParent)
    {
        $this->classParent = $classParent;
    }

    public function getClassParent()
    {
        return $this->classParent;
    }

    public function setClassStaticProperties($classStaticProperties)
    {
        $this->classStaticProperties = $classStaticProperties;
    }

    public function getClassStaticProperties()
    {
        return $this->classStaticProperties;
    }

    public function setIsCustomData($isCustomData)
    {
        $this->isCustomData = $isCustomData;
    }

    public function getIsCustomData()
    {
        return $this->isCustomData;
    }

    public function setIsLeaf($isLeaf)
    {
        $this->isLeaf = $isLeaf;
    }

    public function getIsLeaf()
    {
        return $this->isLeaf;
    }

    public function setObjectCustomData($objectCustomData)
    {
        $this->objectCustomData = $objectCustomData;
    }

    public function getObjectCustomData()
    {
        return $this->objectCustomData;
    }

    public function setObjectProperties($objectProperties)
    {
        $this->objectProperties = $objectProperties;
    }

    public function getObjectProperties()
    {
        return $this->objectProperties;
    }

    public function setToString($toString)
    {
        $this->toString = $toString;
    }

    public function getToString()
    {
        return $this->toString;
    }

    public function hasClassInfo()
    {
        return (
            !empty($this->classFile) ||
            !empty($this->classInterfaces) ||
            !empty($this->classNamespace) ||
            !empty($this->classParent)
        );
    }


    public function getName()
    {
        return 'object';
    }


}
