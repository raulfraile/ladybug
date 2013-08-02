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

use Ladybug\Type\ObjectType as Object;

use Ladybug\Type\Exception\InvalidVariableTypeException;

class ObjectType extends AbstractType
{

    const TYPE_ID = 'object';

    const CLASSINFO_BUILTIN = 'built-in';

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

    /** @var boolean $abstract */
    protected $abstract;

    /** @var boolean $final */
    protected $final;

    protected $terminal;

    /** @var string $icon */
    protected $icon;

    /** @var string $helpLink */
    protected $helpLink;

    /** @var string $version */
    protected $version;

    protected $maxLevel;

    /** @var FactoryType $factory */
    protected $factory;

    /** @var ObjectMetadataResolver $metadataResolver */
    protected $metadataResolver;

    protected $inspectorFactory;

    public function __construct($maxLevel, FactoryType $factory, \Ladybug\Inspector\InspectorFactory $inspectorFactory, \Ladybug\Metadata\MetadataResolver $metadataResolver)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->level = 0;
        $this->maxLevel = $maxLevel;
        $this->factory = $factory;
        $this->metadataResolver = $metadataResolver;

        $this->inspectorFactory = $inspectorFactory;
    }

    public function load($var)
    {
        if (!is_object($var)) {
            throw new InvalidVariableTypeException();
        }

        $this->className = get_class($var);

        $this->toString = (method_exists($var, '__toString')) ? $var->__toString() : null;

        if ($this->level < $this->maxLevel) {
            $this->terminal = false;

            $reflectedClass = new \ReflectionClass($this->className);

            // Class info
            $this->loadClassInfo($reflectedClass);

            // Object data
            $this->loadData($var, $reflectedClass);

            // Class constants
            $this->loadClassConstants($reflectedClass);

            // Object properties
            //$this->loadObjectProperties($reflectedClass);

            // Class methods
            $this->loadClassMethods($reflectedClass);

            // metadata
            if ($this->metadataResolver->has($this->className)) {
                $metadata = $this->metadataResolver->getMetadata($this->className);

                if (array_key_exists('help_link', $metadata)) {
                    $this->helpLink = $metadata['help_link'];
                }

                if (array_key_exists('icon', $metadata)) {
                    $this->icon = $metadata['icon'];
                }

                if (array_key_exists('version', $metadata)) {
                    $this->version = $metadata['version'];
                }
            }

        } else {
            $this->terminal = true;
        }

    }

    public function setClassConstants($classConstants)
    {
        $this->classConstants = $classConstants;
    }

    public function getClassConstants()
    {
        return $this->classConstants;
    }

    public function getConstantByName($name)
    {
        foreach ($this->classConstants as $constant) {
            /** @var Object\Constant $constant */

            if ($constant->getName() === $name) {
                return $constant;
            }
        }

        return null;
    }

    public function getMethodByName($name)
    {
        foreach ($this->classMethods as $method) {
            /** @var Object\Method $method */

            if ($method->getName() === $name) {
                return $method;
            }
        }

        return null;
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

    public function setTerminal($isLeaf)
    {
        $this->terminal = $isLeaf;
    }

    public function getTerminal()
    {
        return $this->terminal;
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

    public function getObjectProperty($name, $visibility)
    {
        foreach ($this->objectProperties as $property) {
            /** @var Object\Property $property */

            if ($property->getName() === $name && $property->getVisibility() === $visibility) {
                return $property;
            }
        }

        return null;
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

    public function getTemplateName()
    {
        return 'object';
    }

    protected function loadClassInfo(\ReflectionClass $reflectedObject)
    {
        $this->classFile = $reflectedObject->getFileName();
        if (empty($this->classFile)) {
            $this->classFile = self::CLASSINFO_BUILTIN;
        }
        $this->classInterfaces = implode(', ', $reflectedObject->getInterfaceNames());
        $this->classNamespace = $reflectedObject->getNamespaceName();
        $parent = $reflectedObject->getParentClass();
        if ($parent) {
            $this->classParent = $parent->getName();
        }

        $this->abstract = $reflectedObject->isAbstract();
        $this->final = $reflectedObject->isFinal();
    }

    protected function loadClassConstants(\ReflectionClass $reflectedObject)
    {
        $this->classConstants = array();

        $constants = $reflectedObject->getConstants();
        if (!empty($constants)) {
            foreach ($constants as $constantName => $constantValue) {
                $valueType = $this->factory->factory($constantValue, $this->level);
                $this->classConstants[] = new Object\Constant($constantName, $valueType);
            }
        }
    }

    protected function loadObjectProperties(\ReflectionClass $reflectedObject)
    {
        /*$properties = $reflectedObject->getProperties();
        $this->objectProperties = array();
        if (!empty($properties)) {
            foreach ($properties as $property) {
                if ($property->isPublic()) {
                    $property_value = $property->getValue($this->value);

                    $this->objectProperties[$property->getName()] = $this->factory->factory($constantValue, $constantName, $this->level);
                        FactoryType::factory($property_value, $this->level, $this->container);
                }
            }
        }*/
    }

    protected function loadClassMethods(\ReflectionClass $reflectedObject)
    {
        $this->classMethods = array();
        $classMethods = $reflectedObject->getMethods();
        if (!empty($classMethods)) {
            foreach ($classMethods as $classMethod) {
                $reflectedMethod = $reflectedObject->getMethod($classMethod->name);

                $method = new Object\Method();
                $method->setName($reflectedMethod->getName());

                // static
                if ($reflectedMethod->isStatic()) {
                    $method->setIsStatic(true);
                }

                // visibility
                if ($reflectedMethod->isPublic()) {
                    $method->setVisibility(Object\VisibilityInterface::VISIBILITY_PUBLIC);
                } elseif ($reflectedMethod->isProtected()) {
                    $method->setVisibility(Object\VisibilityInterface::VISIBILITY_PROTECTED);
                } elseif ($reflectedMethod->isPrivate()) {
                    $method->setVisibility(Object\VisibilityInterface::VISIBILITY_PRIVATE);
                }

                // phpdoc comment
                $phpdoc = new \phpDocumentor\Reflection\DocBlock($reflectedMethod->getDocComment());

                $method->setShortDescription($phpdoc->getShortDescription());
                $method->setLongDescription($phpdoc->getLongDescription());

                // parameters
                $methodParameters = $reflectedMethod->getParameters();

                foreach ($methodParameters as $methodParameterReflected) {

                    $methodParameter = new Object\MethodParameter();
                    $methodParameter->setName($methodParameterReflected->getName());

                    $class = $methodParameterReflected->getClass();

                    if ($class instanceof \ReflectionClass) {
                        $methodParameter->setType($class->getName());
                    } elseif ($methodParameterReflected->isArray()) {
                        $methodParameter->setType('array');
                    }

                    if ($methodParameterReflected->isPassedByReference()) {
                        $methodParameter->setIsReference(true);
                    }

                    if ($methodParameterReflected->isDefaultValueAvailable()) {
                        $default = $methodParameterReflected->getDefaultValue();
                        $defaultValueType = $this->factory->factory($default, $this->level + 1);

                        $methodParameter->setDefaultValue($defaultValueType);
                    }

                    $method->addMethodParameter($methodParameter);
                }

                $this->classMethods[] = $method;
            }
        }

        // order methods
        usort($this->classMethods, function(Object\Method $methodA, Object\Method $methodB) {

            $orderValueA = $methodA->getVisibility() . $methodA->getName();
            $orderValueB = $methodB->getVisibility() . $methodB->getName();

            return strcasecmp($orderValueA, $orderValueB);
        });

    }

    protected function loadData($var, \ReflectionClass $reflectedObject)
    {
        // is there a class to show the object data?
        $service = 'inspector_object_'.str_replace('\\', '_', strtolower($this->className));

        if ($this->inspectorFactory->has($service)) {
            $inspector = $this->inspectorFactory->factory($service);
            $this->objectCustomData = $inspector->getData($var);
        }

        // properties
        $data = (array) $var;

        // unmangle private and protected
        $this->objectProperties = array();
        foreach ($data as $key => $item) {

            if (0 === strpos($key, "\0*\0")) {
                $propertyName = substr($key, 3);
                $propertyVisibility = Object\VisibilityInterface::VISIBILITY_PROTECTED;
            } elseif (0 === strpos($key, "\0" . $this->className . "\0")) {
                $propertyName = substr($key, 2 + strlen($this->className));
                $propertyVisibility = Object\VisibilityInterface::VISIBILITY_PRIVATE;
            } else {
                $propertyName = $key;
                $propertyVisibility = Object\VisibilityInterface::VISIBILITY_PUBLIC;
            }

            $objectProperty = new Object\Property();
            $objectProperty->setName($propertyName);
            $objectProperty->setValue($this->factory->factory($item, $this->level));
            $objectProperty->setVisibility($propertyVisibility);

            $this->objectProperties[] = $objectProperty;
        }

    }

    /**
     * @param string $helpLink
     */
    public function setHelpLink($helpLink)
    {
        $this->helpLink = $helpLink;
    }

    /**
     * @return string
     */
    public function getHelpLink()
    {
        return $this->helpLink;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function isComposed()
    {
        return true;
    }

    /**
     * @param boolean $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param boolean $final
     */
    public function setFinal($final)
    {
        $this->final = $final;
    }

    /**
     * @return boolean
     */
    public function isFinal()
    {
        return $this->final;
    }




}
