<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Processor / Zend
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Processor;

class Zend implements ProcessorInterface
{

    public function isProcessable($str)
    {
        return strpos($str, 'Zend') !== false;
    }

    public function process($str)
    {
        $matches = array();
        $result = $str;

        if (preg_match_all('/\(Zend[\\\\A-Za-z]+\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);

            foreach ($matches as $m) {
                $class = str_replace('(', '',str_replace(')', '', $m));

                $result = str_replace($m, '(<a href="#" class="doc zendframework" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }

        }

        return $result;
    }
}
