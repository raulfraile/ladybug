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

/**
 * Method is an abstraction of a class method
 */
class Method implements VisibilityInterface
{

    /** @var string $name */
    protected $name;

    /** @var string $name */
    protected $visibility;

    /** @var bool $static */
    protected $static = false;

    /** @var MethodParameter[] $parameters */
    protected $parameters;

    /** @var string $shortDescription */
    protected $shortDescription;

    /** @var string $longDescription */
    protected $longDescription;

    /** @var int $level */
    protected $level;

    /**
     * Sets the method name.
     * @param string $name Method name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the method name.
     *
     * @return string Method name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @inheritdoc
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Sets or unsets the method as static.
     * @param boolean $static True if the method is static
     */
    public function setStatic($static = true)
    {
        $this->static = (boolean) $static;
    }

    /**
     * Checks if the method is static
     *
     * @return boolean True for static methods. False otherwise
     */
    public function isStatic()
    {
        return $this->static;
    }

    /**
     * Sets the method parameters.
     * @param MethodParameter[] $parameters Method parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Gets the method parameters.
     *
     * @return MethodParameter[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Gets a paramater by name.
     * @param string $name Parameter name
     *
     * @return MethodParameter|null
     */
    public function getParameterByName($name)
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter->getName() === $name) {
                return $parameter;
            }
        }

        return null;
    }

    /**
     * Adds a new method parameter.
     * @param MethodParameter $methodParameter
     */
    public function addMethodParameter(MethodParameter $methodParameter)
    {
        $this->parameters[] = $methodParameter;
    }

    /**
     * Sets the method long description.
     * @param string $longDescription
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;
    }

    /**
     * Gets the method long description.
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Sets the method short description.
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * Gets the method short description
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

}
