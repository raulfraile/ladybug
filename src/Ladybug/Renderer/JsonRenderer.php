<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Renderer;

use Ladybug\Format\JsonFormat;

/**
 * JsonRenderer serializes a collection of nodes in JSON
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class JsonRenderer extends AbstractSerializingRenderer
{

    /**
     * @inheritdoc
     */
    public function getFormat()
    {
        return JsonFormat::FORMAT_NAME;
    }

}
