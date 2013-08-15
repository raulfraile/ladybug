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

namespace Ladybug\Metadata;

interface MetadataInterface
{

    const TYPE_CLASS = 0;
    const TYPE_RESOURCE = 1;

    /**
     * Process the HTML code and make the proper changes
     *
     * @param  string $str html code
     * @return string modified html code
     */
    public function getMetadata($id, $type = self::TYPE_CLASS);

    public function hasMetadata($id, $type = self::TYPE_CLASS);

}
