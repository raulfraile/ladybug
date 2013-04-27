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

class TableType extends BaseType
{

    const TYPE_ID = 'table';

    protected $header;

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function load($var, $key = null)
    {
        $this->data = $var;
        $this->key = $key;
    }


    public static function create($var, $key = null)
    {
        $object = new static();
        $object->load($var, $key);

        return $object;
    }

}
