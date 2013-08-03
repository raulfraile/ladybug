<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Resources/File dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Inspector\Resource;

use Ladybug\Inspector\AbstractInspector;
use Ladybug\Type;

class File extends AbstractInspector
{
    /**
     * @param  string                                $var
     * @return \Ladybug\Type\Extended\CollectionType
     */
    public function getData($var)
    {

        if (!is_resource($var) || get_resource_type($var) != 'stream') {
            throw new \Ladybug\Exception\InvalidInspectorClassException();
        }

        /** @var resource $var */

        $result = array();

        $streamVars = stream_get_meta_data($var);
        $fstat = fstat($var);

        $realPath = realpath($streamVars['uri']);

        $result['file'] = $realPath;

        /** @var $collection Type\Extended\CollectionType */
        $collection = $this->extendedTypeFactory->factory('collection', $this->level);
        $collection->setTitle('File');

        $result = array();
        $result['mode'] = $this->typeFactory->factory($fstat['mode'], $this->level);

        /** @var $mode Type\Extended\UnixPermissionsType */
        $mode = $this->extendedTypeFactory->factory('unixpermissions', $this->level);
        $mode->setKey('Permissions');
        $mode->load($fstat['mode']);
        $result['mode'] = $mode;

        /** @var $size Type\Extended\SizeType */
        $size = $this->extendedTypeFactory->factory('size', $this->level);
        $size->setKey('Size');
        $size->load($fstat['size']);
        $result['size'] = $size;


        $collection->loadFromArray($result, true);
        $collection->setLevel($this->level);

        return $collection;
    }

}
