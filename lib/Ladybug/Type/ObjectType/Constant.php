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

use Ladybug\Type\TypeInterface;

class Constant
{

    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PROTECTED = 'protected';
    const VISIBILITY_PRIVATE = 'private';

    /** @var string $name */
    protected $name;

    /** @var TypeInterface $value */
    protected $value;

    public function __construct($name, TypeInterface $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Ladybug\Type\TypeInterface $value
     */
    public function setValue(TypeInterface $value)
    {
        $this->value = $value;
    }

    /**
     * @return \Ladybug\Type\TypeInterface
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getLevel()
    {
        return $this->value->getLevel();
    }
}
