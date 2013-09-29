<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * AbstractPlugin class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector;

use Ladybug\Type\FactoryType;
use Ladybug\Type\ExtendedTypeFactory;
use Ladybug\Type;
use Ladybug\Model\VariableWrapper;

abstract class AbstractInspector implements InspectorInterface
{

    /** @var FactoryType $typeFactory */
    protected $typeFactory;

    /** @var ExtendedTypeFactory $extendedTypeFactory */
    protected $extendedTypeFactory;

    protected $level;

    public function __construct(FactoryType $typeFactory, ExtendedTypeFactory $extendedTypeFactory, $level = 0)
    {
        $this->typeFactory = $typeFactory;
        $this->extendedTypeFactory = $extendedTypeFactory;
        $this->level = $level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param $text
     * @param $key
     * @return \Ladybug\Type\Extended\TextType
     */
    public function createTextType($text, $key)
    {
        /** @var $textType Type\Extended\TextType */
        $textType = $this->extendedTypeFactory->factory('text', $this->level);

        $textType->setKey($key);
        $textType->setText($text);

        return $textType;
    }

    /**
     * @param $text
     * @param $key
     * @return \Ladybug\Type\Extended\ImageType
     */
    public function createImageType($image, $key)
    {
        /** @var $imageType Type\Extended\ImageType */
        $imageType = $this->extendedTypeFactory->factory('image', $this->level);

        $imageType->setKey($key);
        $imageType->setImage($image);

        return $imageType;
    }

    public function createContainer($title, Type\Extended\ExtendedTypeInterface $data)
    {
        /** @var $containerType Type\Extended\ContainerType */
        $containerType = $this->extendedTypeFactory->factory('container', $this->level);

        $containerType->setTitle($title);
        $containerType->setData($data);

        return $containerType;
    }

    /**
     * Returns the object data into an array/string
     *
     * @param  string $var html code
     * @return string modified html code
     */
    public function get(VariableWrapper $data)
    {
        return null;
    }

    public function supports(VariableWrapper $data)
    {
        return false;
    }

}
