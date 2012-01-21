<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Processor / Doctrine
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Processor;

class Doctrine implements ProcessorInterface
{
    
    private $doctrine_prefix = 'http://www.doctrine-project.org/api/orm/2.1/';
    
    public function process($str)
    {
        $matches = array();
        $result = $str;
        
        if (preg_match_all('/\(Doctrine[\\\\A-Za-z]+\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);
            
            foreach ($matches as $m) {
                $class = str_replace('(', '',str_replace(')', '', $m));
                $class_url = strtolower($class) . '.html';
                
                $result = str_replace($m, '(<a href="' . $this->doctrine_prefix . $class_url . '" class="doc doctrine" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }
            
        }
    
        return $result;
    }

}