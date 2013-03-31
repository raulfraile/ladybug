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

namespace Ladybug\Extension\Type;

use Twig_Loader_Filesystem;
use Twig_Environment;


abstract class BaseType
{

    const TYPE_ID = 'base';

    protected $id;

    protected $data;

    /**
     * Constructor
     *
     * @param string  $var
     * @param mixed   $level
     * @param Options $options
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->id = 'ext_' . static::TYPE_ID . '_' . ((int) rand(1, 100));
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function render($array_key = NULL, $format = 'html', $escape = false, $level = 1)
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/View');
        $twig = new Twig_Environment($loader);

        $result = $twig->render(static::TYPE_ID.'.'.$format.'.twig', array_merge(
            array(
                'imports' => array(file_get_contents(__DIR__.'/../../Asset/js/raphaeljs.js'))
            ),//$this->getViewParameters(),
            array('var' => $this, 'array_key' => $array_key, 'level' => $level)

        ));

        return $result;
    }

    public function getId()
    {
        return $this->id;
    }

}
