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
        $streamVars = stream_get_meta_data($var);
        $fstat = fstat($var);

        $realPath = realpath($streamVars['uri']);

        $result = array();

        $result['file'] = $this->createTextType($realPath, 'Real path');

        $mimetype = $this->getMimetype($realPath);
        $result['mimetype'] = $this->createTextType($mimetype, 'MIME');

        /** @var $collection Type\Extended\CollectionType */
        $collection = $this->extendedTypeFactory->factory('collection', $this->level);
        $collection->setTitle('File');

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

        $result['atime'] = $this->createTextType($this->createDateTimeFromTimestamp($fstat['atime'])->format('c'), 'atime');
        $result['mtime'] = $this->createTextType($this->createDateTimeFromTimestamp($fstat['mtime'])->format('c'), 'mtime');
        $result['ctime'] = $this->createTextType($this->createDateTimeFromTimestamp($fstat['ctime'])->format('c'), 'ctime');
        $result['uid'] = $this->createTextType($fstat['uid'], 'uid');
        $result['gid'] = $this->createTextType($fstat['gid'], 'gid');

        if ($this->isText($mimetype)) {
            /** @var $fileContent Type\Extended\CodeType */
            $fileContent = $this->extendedTypeFactory->factory('code', $this->level);
            $fileContent->setData(file_get_contents($realPath));
            //$fileContent->setKey('Content');
            $fileContent->setLanguage($mimetype);
            $fileContent->setTitle('Contents');
            $result['content'] = $fileContent;
        }

        $collection->loadFromArray($result, true);
        $collection->setLevel($this->level);
        $collection->setTitle('File');

        return $collection;
    }

    protected function createDateTimeFromTimestamp($timestamp)
    {
        return new \DateTime('@' . $timestamp);
    }

    protected function getMimetype($filename)
    {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);

        if (false !== strpos($mimetype, ';')) {
            $mimetype = substr($mimetype, 0, strpos($mimetype, ';'));
        }

        return $mimetype;
    }

    protected function isText($mimetype)
    {
        return 'text' === substr($mimetype, 0, 4);
    }

}
