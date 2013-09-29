<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * ProcessorInterface
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector;

use Ladybug\Model\VariableWrapper;

/**
 * InspectorInterface is the interface implemented by all inspector classes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface InspectorInterface
{

    /**
     * Gets extra info for an object/resource
     * @param VariableWrapper $data
     *
     * @return array
     */
    public function get(VariableWrapper $data);

    /**
     * Checks whether the class accepts the object/resource
     * @param VariableWrapper $data
     *
     * @return boolean
     */
    public function supports(VariableWrapper $data);
}
