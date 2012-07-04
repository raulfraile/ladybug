<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Processor / RFC
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Processor;

class RFC implements ProcessorInterface
{

    public function isProcessable($str)
    {
        return strpos($str, 'RFC') !== false;
    }

    public function process($str)
    {
        return preg_replace('/RFC([0-9]+)/', '<a href="http://www.rfc-editor.org/rfc/rfc\1.txt" class="external" target="_blank"></a>RFC\1', $str);
    }
}
