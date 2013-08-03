<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * ExtensionBase class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector;

use Ladybug\Type\FactoryType;
use Ladybug\Type\Extended\ExtendedTypeFactory;

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

}
