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
    
    private $doctrine_orm_prefix = 'http://www.doctrine-project.org/api/orm/2.1/';
    private $doctrine_dbal_prefix = 'http://www.doctrine-project.org/api/dbal/2.1/';
    private $doctrine_mongodb_odm_prefix = 'http://www.doctrine-project.org/api/mongodb_odm/1.0/';
    private $doctrine_common_prefix = 'http://www.doctrine-project.org/api/common/2.1/';
    
    public function process($str)
    {
        $matches = array();
        $result = $str;
        
        // ORM classes
        if (preg_match_all('/\(Doctrine\\\\ORM[\\\\A-Za-z]*\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);
            
            foreach ($matches as $m) {
                $class = str_replace('(', '', str_replace(')', '', $m));
                $class_url = strtolower($class) . '.html';
                
                $result = str_replace($m, '(<a href="' . $this->doctrine_orm_prefix . $class_url . '" class="doc doctrine" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }
        }

        // DBAL classes
        if (preg_match_all('/\(Doctrine\\\\DBAL[\\\\A-Za-z]*\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);
            
            foreach ($matches as $m) {
                $class = str_replace('(', '', str_replace(')', '', $m));
                $class_url = strtolower($class) . '.html';
                
                $result = str_replace($m, '(<a href="' . $this->doctrine_dbal_prefix . $class_url . '" class="doc doctrine" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }
        }

        // MongoDB ODM classes
        if (preg_match_all('/\(Doctrine\\\\ODM\\\\MongoDB[\\\\A-Za-z]*\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);
            
            foreach ($matches as $m) {
                $class = str_replace('(', '', str_replace(')', '', $m));
                $class_url = strtolower($class) . '.html';
                
                $result = str_replace($m, '(<a href="' . $this->doctrine_mongodb_odm_prefix . $class_url . '" class="doc doctrine" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }
        }

        // Common classes
        if (preg_match_all('/\(Doctrine\\\\Common[\\\\A-Za-z]*\)/', $str, $matches)) {
            $matches = array_unique($matches[0]);
            
            foreach ($matches as $m) {
                $class = str_replace('(', '', str_replace(')', '', $m));
                $class_url = strtolower($class) . '.html';
                
                $result = str_replace($m, '(<a href="' . $this->doctrine_common_prefix . $class_url . '" class="doc doctrine" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }
        }
    
        return $result;
    }

}