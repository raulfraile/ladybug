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

namespace Ladybug\Extension;

use Ladybug\Type\FactoryType;

abstract class ExtensionBase implements ExtensionInterface
{

    /** @var FactoryType $factory */
    protected $factory;

    public function __construct(FactoryType $factory)
    {
        $this->factory = $factory;
    }

}
