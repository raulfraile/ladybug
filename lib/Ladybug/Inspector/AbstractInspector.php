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

abstract class AbstractInspector implements InspectorInterface
{

    /** @var FactoryType $factory */
    protected $factory;

    protected $level;

    public function __construct(FactoryType $factory, $level = 0)
    {
        $this->factory = $factory;
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
