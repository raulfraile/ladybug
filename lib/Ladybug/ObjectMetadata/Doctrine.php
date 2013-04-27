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

    public function isProcessable($str)
    {
        return strpos($str, 'Doctrine') !== false;
    }

    public function process($str)
    {
        $matches = array();
        $result = $str;

        $this->processReplace($result, 'Doctrine\ORM', $this->doctrine_orm_prefix);
        $this->processReplace($result, 'Doctrine\DBAL', $this->doctrine_dbal_prefix);
        $this->processReplace($result, 'Doctrine\ODM\MongoDB', $this->doctrine_mongodb_odm_prefix);
        $this->processReplace($result, 'Doctrine\Common', $this->doctrine_common_prefix);

        return $result;
    }

    private function processReplace(& $result, $classPrefix, $apiPrefix)
    {
        $classPrefixRegexp = str_replace('\\', '\\\\', $classPrefix);
        $matches = array();

        if (preg_match_all('/\(' . $classPrefixRegexp . '[\\\\A-Za-z]*\)/', $result, $matches)) {
            $matches = array_unique($matches[0]);

            foreach ($matches as $m) {
                $class = str_replace('(', '', str_replace(')', '', $m));
                $class_url = strtolower($class) . '.html';

                $result = str_replace($m, '(<a href="' . $apiPrefix . $class_url . '" class="doc doctrine" target="_blank" title="'.$class.'"></a>'.$class.')', $result);
            }
        }
    }
}
