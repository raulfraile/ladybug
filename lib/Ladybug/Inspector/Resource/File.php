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

use Ladybug\Dumper;
use Ladybug\Inspector\AbstractInspector;
use Ladybug\Type;

class File extends AbstractInspector
{
    /**
     * @param string $var
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

        $collection = new Type\Extended\CollectionType($this->factory);
        $collection->setTitle('File');

        $result = array();
        $result['mode'] = $this->factory->factory($fstat['mode'], $this->level);

        $mode = new Type\Extended\UnixPermissionsType();
        $mode->setKey('Permissions');
        $mode->load($fstat['mode']);
        $result['mode'] = $mode;

        $size = new Type\Extended\SizeType();
        $size->setKey('Size');
        $size->load($fstat['size']);
        $result['size'] = $size;

        /*$permissions = array('read');
        if (is_writable($real_path)) $permissions[] = 'write';
        if (is_executable($real_path)) $permissions[] = 'execute';
        if (is_link($real_path)) $permissions[] = 'link';
        if (is_dir($real_path)) $permissions[] = 'directory';

        $result['permissions'] = implode(', ', $permissions);*/

        $collection->loadFromArray($result, true);
        $collection->setLevel($this->level);

        return $collection;
    }

}
