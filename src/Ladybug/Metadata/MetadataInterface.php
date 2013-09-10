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

/**
 * MetadataInterface is the interface implemented by all metadata classes
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
interface MetadataInterface
{

    const TYPE_CLASS = 0;
    const TYPE_RESOURCE = 1;

    /**
     * Gets metadata for an object/resource identifier
     * @param string $id   Identifier
     * @param int    $type Type
     *
     * @return array
     */
    public function get($id, $type = self::TYPE_CLASS);


    /**
     * Returns true if the class accepts the object/resource identifier
     * @param string $id   Identifier
     * @param int    $type Type
     *
     * @return boolean
     */
    public function supports($id, $type = self::TYPE_CLASS);

}
