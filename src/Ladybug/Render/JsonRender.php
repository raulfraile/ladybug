<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Ladybug\Format\JsonFormat;

class JsonRender extends AbstractSerializingRender
{

    public function getFormat()
    {
        return JsonFormat::FORMAT_NAME;
    }

}
