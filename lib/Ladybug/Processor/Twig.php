<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Processor / Twig
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Processor;

class Twig implements ProcessorInterface
{

    private $twig_prefix = 'http://twig.sensiolabs.org/api/master/';

    public function isProcessable($str)
    {
        return strpos($str, 'Twig_') !== false;
    }

    public function process($str)
    {
        $matches = array();
        $result = $str;

        if (preg_match_all('/\(Twig_[\_A-Za-z]+\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);

            foreach ($matches as $m) {
                $class = str_replace('(', '',str_replace(')', '', $m));

                $result = str_replace($m, '(<a href="' . $this->twig_prefix . $class . '.html" class="doc twig" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }

        }

        return $result;
    }
}
