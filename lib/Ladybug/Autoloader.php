<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Autoloads Ladybug classes
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

class Ladybug_Autoloader
{
    /**
     * Registers Ladybug_Autoloader as an SPL autoloader.
     */
    static public function register()
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register(array(new self, 'autoload'));
        
        require_once(__DIR__ . '/functions.php');
    }

    /**
     * Handles autoloading of classes.
     *
     * @param  string  $class  A class name.
     * @return boolean Returns true if the class has been loaded
     */
    static public function autoload($class)
    {

        if (0 !== strpos($class, 'Ladybug')) {
            return;
        }
        
        //$class = str_replace('Ladybug\\','', $class);
        
        $file = dirname(__FILE__).'/../'.str_replace(array('_', "\0"), array('/', ''), $class).'.php';
        
        $file = dirname(__FILE__).'/../'.str_replace(array('\\', "\0"), array('/', ''), $class).'.php';
             
        //echo $class.' __ '.$file.' __ ';
        if (is_file($file)) {//echo '*';
            require $file;
        }
        else {
            throw new \Exception("Class $class not found");
        }
    }
}

