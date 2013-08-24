<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class UnixPermissionsType extends AbstractType
{

    const TYPE_ID = 'unix_permissions';

    protected $data;

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

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

}
