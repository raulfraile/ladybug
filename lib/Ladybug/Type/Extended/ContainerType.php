<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * AbstractPlugin class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class ContainerType extends BaseType
{
    const TYPE_ID = 'container';

    public function load($var, $level = 1)
    {

    }

    public function setData($data)
    {
        $data->setLevel($this->level + 1);

        parent::setData($data);
    }

}
