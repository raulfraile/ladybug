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

class UnixPermissionsType extends BaseType
{

    const TYPE_ID = 'unix_permissions';

    public function getFormattedValue()
    {
        $result = '';

        $result .= ($this->data & 256 ? 'r' : '-');
        $result .= ($this->data & 128 ? 'w' : '-');
        $result .= ($this->data & 64 ? 'x' : '-');

        $result .= ($this->data & 32 ? 'r' : '-');
        $result .= ($this->data & 16 ? 'w' : '-');
        $result .= ($this->data & 8 ? 'x' : '-');

        $result .= ($this->data & 4 ? 'r' : '-');
        $result .= ($this->data & 2 ? 'w' : '-');
        $result .= ($this->data & 1 ? 'x' : '-');

        return $result;
    }

    public function getTemplateName()
    {
        return 'unix_permissions';
    }

    public function load($var, $level = 1)
    {
        $this->data = $var;
    }

}
