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

use Ladybug\Metadata\MetadataInterface;
use Ladybug\Model\VariableWrapper;

interface MetadataResolverInterface
{

    /**
     * Adds a new metadata object
     * @param MetadataInterface $metadata
     */
    public function add(MetadataInterface $metadata);

    /**
     * Gets metadata for the class/resource id
     * @param string $id
     * @param int    $type
     *
     * @return array
     */
    public function get(VariableWrapper $data);

    /**
     * Checks if there is a metadata object to handle the given class/resource id
     * @param string $id
     * @param int    $type
     *
     * @return bool
     */
    public function has(VariableWrapper $data);
}
