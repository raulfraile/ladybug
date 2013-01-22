<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Processor / Symfony
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Processor;

class Symfony implements ProcessorInterface
{

    public $sfprefix = 'http://api.symfony.com/2.1/index.html?q=';

    public function isProcessable($str)
    {
        return strpos($str, 'Symfony') !== false;
    }

    public function process($str)
    {
        $matches = array();
        $result = $str;

        if (preg_match_all('/\(Symfony[\\\\A-Za-z]+\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);

            foreach ($matches as $m) {
                $class = str_replace('(', '',str_replace(')', '', $m));

                $result = str_replace($m, '(<a href="' . $this->sfprefix . urlencode($class) . '" class="doc symfony" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }

        }

        return $result;
    }

}
