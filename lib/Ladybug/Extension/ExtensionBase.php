<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * ExtensionBase class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension;

use Pimple;

abstract class ExtensionBase implements ExtensionInterface
{

    protected $var;
    protected $inspect;

    protected $container;

    protected $level;

    public function __construct($var, $level, Pimple $container)
    {
        $this->var = $var;
        $this->inspect = true;
        $this->container = $container;
        $this->level = $level;
    }

    public function getInspect()
    {
        return $this->inspect;
    }

    protected function _formatSize($size, $unit = NULL)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;

        $result = '';

        if ($size < $kb) $result = $size . ' bytes';
        elseif ($size < $mb) $result = number_format($size/$kb, 2) . ' Kb';
        elseif ($size < $gb) $result = number_format($size/$mb, 2) . ' Mb';
        else $result = number_format($size/$gb, 2) . ' Gb';

        return $result;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }


}
