<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Metadata;

use Ladybug\Model\VariableWrapper;

/**
 * MetadataInterface is the interface implemented by all metadata classes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface MetadataInterface
{

    /**
     * Gets metadata for an object/resource
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
