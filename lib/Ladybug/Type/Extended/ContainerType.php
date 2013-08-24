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

use Ladybug\Type\RenderizableTypeInterface;

class ContainerType extends AbstractType
{
    const TYPE_ID = 'container';

    protected $data;

    public function setData(RenderizableTypeInterface $data)
    {
        $data->setLevel($this->level + 1);

        $this->data = $data;
    }

}
