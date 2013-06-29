<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/NullType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\ObjectType;

class Method implements VisibilityInterface
{

    /** @var string $name */
    protected $name;

    /** @var string $name */
    protected $visibility;

    /** @var bool $isStatic */
    protected $isStatic = false;

    /** @var MethodParameter[] $parameters */
    protected $parameters;

    /** @var string $shortDescription */
    protected $shortDescription;

    /** @var string $longDescription */
    protected $longDescription;

    /**
     * Set method name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get method name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param boolean $isStatic
     */
    public function setIsStatic($isStatic)
    {
        $this->isStatic = $isStatic;
    }

    /**
     * @return boolean
     */
    public function getIsStatic()
    {
        return $this->isStatic;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function addMethodParameter(MethodParameter $methodParameter)
    {
        $this->parameters[] = $methodParameter;
    }

    /**
     * @param string $longDescription
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }


}
