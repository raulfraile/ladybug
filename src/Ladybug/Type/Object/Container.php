<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Object;

use Ladybug\Inspector\InspectorInterface;
use Ladybug\Model\VariableWrapper;
use Ladybug\Type\Exception\InvalidVariableTypeException;
use Ladybug\Metadata\MetadataResolver;
use Ladybug\Type\AbstractType;
use Ladybug\Type\FactoryType;

class Container extends AbstractType
{

    const TYPE_ID = 'object';

    const CLASSINFO_BUILTIN = 'built-in';

    /** @var string $className Name of the class */
    protected $className = null;

    /** @var array $classConstants Class constants */
    protected $classConstants = array();

    /** @var array $classStaticProperties Class static properties */
    protected $classStaticProperties = array();

    /** @var array $classMethods Class methods */
    protected $classMethods = array();

    /** @var null|string $classFile Class filename */
    protected $classFile = null;

    /** @var array $classInterfaces Class interfaces */
    protected $classInterfaces = array();

    /** @var null|string $classNamespace Class namespace */
    protected $classNamespace = null;

    /** @var null|string $classParent Class parent */
    protected $classParent = null;

    /** @var array $classTraits Class traits */
    protected $classTraits = array();

    /** @var array $objectProperties Object properties */
    protected $objectProperties = array();

    /** @var null $objectCustomData Object custom data */
    protected $objectCustomData = null;


    protected $toString = null;

    /** @var boolean $abstract */
    protected $abstract;

    /** @var boolean $final */
    protected $final;

    /** @var boolean $cloneable */
    protected $cloneable;

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

    /** @var MetadataResolver $metadataResolver */
    protected $metadataResolver;

    protected $inspectorManager;

    protected $privatePropertiesNumber = 0;
    protected $protectedPropertiesNumber = 0;
    protected $publicPropertiesNumber = 0;

    protected $privateMethodsNumber = 0;
    protected $protectedMethodsNumber = 0;
    protected $publicMethodsNumber = 0;

    /** @var VariableWrapper $variableWrapper */
    protected $variableWrapper;

    public function __construct($maxLevel, FactoryType $manager, \Ladybug\Inspector\InspectorManager $inspectorManager, \Ladybug\Metadata\MetadataResolver $metadataResolver)
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
        $this->level = 0;
        $this->maxLevel = $maxLevel;
        $this->factory = $manager;
        $this->metadataResolver = $metadataResolver;

        $this->inspectorManager = $inspectorManager;
    }

    public function load($var, $level = 1)
    {
        if (!is_object($var)) {
            throw new InvalidVariableTypeException();
        }

        $this->level = $level;
        $this->className = get_class($var);

        $this->toString = (method_exists($var, '__toString')) ? $var->__toString() : null;

        if ($this->level < $this->maxLevel) {
            $this->terminal = false;



            $reflectedClass = new \ReflectionClass($this->className);

            // Class info
            $this->loadClassInfo($reflectedClass);

            $this->variableWrapper = new VariableWrapper($this->className, $var, VariableWrapper::TYPE_CLASS);

            // Object data
            $this->loadData($var, $reflectedClass);

            // Class constants
            $this->loadClassConstants($reflectedClass);

            // Object properties
            //$this->loadObjectProperties($reflectedClass);

            // Class methods
            $this->loadClassMethods($reflectedClass);

            // metadata
            if ($this->metadataResolver->has($this->variableWrapper)) {
                $metadata = $this->metadataResolver->get($this->variableWrapper);

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

    public function getClassConstants()
    {
        return $this->classConstants;
    }

    public function getConstantByName($name)
    {
        foreach ($this->classConstants as $constant) {
            /** @var Constant $constant */

            if ($constant->getName() === $name) {
                return $constant;
            }
        }

        return null;
    }

    public function getMethodByName($name)
    {
        foreach ($this->classMethods as $method) {
            /** @var Method $method */

            if ($method->getName() === $name) {
                return $method;
            }
        }

        return null;
    }

    public function getClassFile()
    {
        return $this->classFile;
    }

    public function getClassInterfaces()
    {
        return $this->classInterfaces;
    }

    public function getClassMethods()
    {
        return $this->classMethods;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getClassNamespace()
    {
        return $this->classNamespace;
    }

    public function getClassParent()
    {
        return $this->classParent;
    }

    public function getClassStaticProperties()
    {
        return $this->classStaticProperties;
    }

    public function isTerminal()
    {
        return $this->terminal;
    }

    public function getObjectCustomData()
    {
        return $this->objectCustomData;
    }

    public function getObjectProperties()
    {
        return $this->objectProperties;
    }

    public function getObjectProperty($name, $visibility)
    {
        foreach ($this->objectProperties as $property) {
            /** @var Property $property */

            if ($property->getName() === $name && $property->getVisibility() === $visibility) {
                return $property;
            }
        }

        return null;
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

        if (version_compare(phpversion(), '5.4', '>=')) {
            $this->classTraits = implode(', ', $reflectedObject->getTraitNames());
        }

        $this->abstract = $reflectedObject->isAbstract();
        $this->final = $reflectedObject->isFinal();

        if (version_compare(phpversion(), '5.4', '>=')) {
            $this->cloneable = $reflectedObject->isCloneable();
        }
    }

    protected function loadClassConstants(\ReflectionClass $reflectedObject)
    {
        $this->classConstants = array();

        $constants = $reflectedObject->getConstants();
        if (!empty($constants)) {
            foreach ($constants as $constantName => $constantValue) {
                $valueType = $this->factory->factory($constantValue, $this->level + 1);
                $this->classConstants[] = new Constant($constantName, $valueType);
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

                $method = new Method();
                $method->setName($reflectedMethod->getName());
                $method->setLevel($this->level + 1);

                // static
                if ($reflectedMethod->isStatic()) {
                    $method->setStatic();
                }

                // visibility
                if ($reflectedMethod->isPublic()) {
                    $method->setVisibility(VisibilityInterface::VISIBILITY_PUBLIC);
                    $this->publicMethodsNumber++;
                } elseif ($reflectedMethod->isProtected()) {
                    $method->setVisibility(VisibilityInterface::VISIBILITY_PROTECTED);
                    $this->protectedMethodsNumber++;
                } elseif ($reflectedMethod->isPrivate()) {
                    $method->setVisibility(VisibilityInterface::VISIBILITY_PRIVATE);
                    $this->privateMethodsNumber++;
                }

                // phpdoc comment
                if (class_exists('\phpDocumentor\Reflection\DocBlock')) {
                    $phpdoc = new \phpDocumentor\Reflection\DocBlock($reflectedMethod->getDocComment());

                    $method->setShortDescription($phpdoc->getShortDescription());
                    $method->setLongDescription($phpdoc->getLongDescription());
                }

                // parameters
                $methodParameters = $reflectedMethod->getParameters();

                foreach ($methodParameters as $methodParameterReflected) {

                    $methodParameter = new MethodParameter();
                    $methodParameter->setName($methodParameterReflected->getName());

                    try {
                        $class = $methodParameterReflected->getClass();
                    } catch (\ReflectionException $e) {
                        // This happens when the class method uses an undefined type hint
                        $methodParameter->setType('[Undefined Type Hint]');
                    }

                    if ($class instanceof \ReflectionClass) {
                        $methodParameter->setType($class->getName());
                    } elseif ($methodParameterReflected->isArray()) {
                        $methodParameter->setType('array');
                    }

                    if ($methodParameterReflected->isPassedByReference()) {
                        $methodParameter->setReference();
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
        usort($this->classMethods, function(Method $methodA, Method $methodB) {

            $orderValueA = $methodA->getVisibility() . $methodA->getName();
            $orderValueB = $methodB->getVisibility() . $methodB->getName();

            return strcasecmp($orderValueA, $orderValueB);
        });

    }

    protected function loadData($var, \ReflectionClass $reflectedObject)
    {
        $inspector = $this->inspectorManager->get($this->variableWrapper);
        if ($inspector instanceof InspectorInterface) {
            $inspector->setLevel($this->level + 1);

            $this->objectCustomData = $inspector->get($this->variableWrapper);
        }

        $this->objectProperties = array();

        $properties = $reflectedObject->getProperties();
        foreach ($properties as $key => $item) {

            $item->setAccessible(true);

            $value = $this->factory->factory($item->getValue($var), $this->level + 1);

            $objectProperty = new Property();
            $objectProperty->setName($item->getName());
            $objectProperty->setValue($value);
            $objectProperty->setStatic($item->isStatic());

            if ($item->isPrivate()) {
                $objectProperty->setVisibility(VisibilityInterface::VISIBILITY_PRIVATE);
                $this->privatePropertiesNumber++;
            } elseif ($item->isProtected()) {
                $objectProperty->setVisibility(VisibilityInterface::VISIBILITY_PROTECTED);
                $this->protectedPropertiesNumber++;
            } else {
                $objectProperty->setVisibility(VisibilityInterface::VISIBILITY_PUBLIC);
                $this->publicPropertiesNumber++;
            }

            //$objectProperty->setVisibility($propertyVisibility);
            $objectProperty->setOwner($item->getDeclaringClass()->getName());

            $this->objectProperties[] = $objectProperty;
        }

        // order properties
        usort($this->objectProperties, function(Property $propertyA, Property $propertyB) {

            $orderValueA = ((int) !$propertyA->getStatic()) . $propertyA->getVisibility() . $propertyA->getName();
            $orderValueB = ((int) !$propertyB->getStatic()) . $propertyB->getVisibility() . $propertyB->getName();

            return strcasecmp($orderValueA, $orderValueB);
        });

    }

    /**
     * @return string
     */
    public function getHelpLink()
    {
        return $this->helpLink;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->abstract;
    }

    /**
     * @return boolean
     */
    public function isFinal()
    {
        return $this->final;
    }

    /**
     * @return boolean
     */
    public function isCloneable()
    {
        return $this->cloneable;
    }

    public function getClassTraits()
    {
        return $this->classTraits;
    }

    public function getPrivatePropertiesNumber()
    {
        return $this->privatePropertiesNumber;
    }

    public function getProtectedPropertiesNumber()
    {
        return $this->protectedPropertiesNumber;
    }

    public function getPublicPropertiesNumber()
    {
        return $this->publicPropertiesNumber;
    }

    public function getPrivateMethodsNumber()
    {
        return $this->privateMethodsNumber;
    }

    public function getProtectedMethodsNumber()
    {
        return $this->protectedMethodsNumber;
    }

    public function getPublicMethodsNumber()
    {
        return $this->publicMethodsNumber;
    }

}
