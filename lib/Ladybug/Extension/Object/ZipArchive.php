<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Object/DomDocument dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;
use Ladybug\Extension\Type;

class ZipArchive extends ExtensionBase
{
    public function getData($var)
    {
        $result = array();

        $result['Filename'] = $var->filename;
        $result['Status'] = $var->status;
        $result['StatusSys'] = $var->statusSys;
        $result['Comment'] = $var->comment;

        $files = array();
        for ($i=0; $i<$var->numFiles;$i++) {
            $stats_index = $var->statIndex($i);
            $result['Files'][] = $stats_index['name'] . ' (' .$stats_index['size'] . ')';
        }

        $collection = Type\CollectionType::create(array(
            Type\TextType::create($var->filename, 'Filename'),
            $this->factory->factory($var->status, 'Status'),
            $this->factory->factory($var->statusSys, 'StatusSys'),
            $this->factory->factory($var->comment, 'Comment')
        ));

        // files
        $filesCollection = new Type\CollectionType();
        $filesCollection->setTitle('Files');
        for ($i=0; $i<$var->numFiles;$i++) {
            $stats_index = $var->statIndex($i);
            $filesCollection->add(Type\TextType::create($stats_index['name'] . ' (' .$stats_index['size'] . ')'));
        }

        $collection->add($filesCollection);

        return $collection;
    }

}
