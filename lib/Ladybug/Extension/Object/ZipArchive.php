<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Oject/DomDocument dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Object;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

class ZipArchive extends ExtensionBase
{
    public function dump($var)
    {
        $result = array();

        $result['Filename'] = $var->filename;
        $result['Status'] = $var->status;
        $result['StatusSys'] = $var->statusSys;
        $result['Comment'] = $var->comment;

        $files = array();
        for ($i=0; $i<$var->numFiles;$i++) {
            $stats_index = $var->statIndex($i);
            $result['Files'][] = $stats_index['name'] . ' (' .$this->_formatSize($stats_index['size']) . ')';
        }

        return $result;
    }

    public function getInspect()
    {
        return TRUE;
    }

}
