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

namespace Ladybug\Extension\Resource;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;

class File extends ExtensionBase
{
    public function dump($var)
    {
        $result = array();

        $stream_vars = stream_get_meta_data($var);
        $fstat = fstat($var);

        $real_path = realpath($stream_vars['uri']);

        $result['file'] = $real_path;
        $result['mode'] = $fstat['mode'];
        $result['size'] = $this->_formatSize($fstat['size']);

        $permissions = array('read');
        if (is_writable($real_path)) $permissions[] = 'write';
        if (is_executable($real_path)) $permissions[] = 'execute';
        if (is_link($real_path)) $permissions[] = 'link';
        if (is_dir($real_path)) $permissions[] = 'directory';

        $result['permissions'] = implode(', ', $permissions);

        return $result;
    }

}
