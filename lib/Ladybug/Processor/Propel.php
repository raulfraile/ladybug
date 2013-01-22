<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Processor / Propel
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Processor;

class Propel implements ProcessorInterface
{

    private $propel_prefix = 'http://api.propelorm.org/1.6.6/';

    public function isProcessable($str)
    {
        return strpos($str, 'Propel') !== false;
    }

    public function process($str)
    {
        $matches = array();
        $result = $str;

        if (preg_match_all('/\(Propel[\\\\A-Za-z]+\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);

            foreach ($matches as $m) {
                $class = str_replace('(', '',str_replace(')', '', $m));

                $result = str_replace($m, '(<a href="' . $this->propel_prefix . '" class="doc silex" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }

        }

        return $result;
    }
}
