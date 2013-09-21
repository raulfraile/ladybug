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

use Ladybug\Format\XmlFormat;

/**
 * XmlRenderer serializes a collection of nodes in XML
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class XmlRenderer extends AbstractSerializingRenderer
{

    /**
     * @inheritdoc
     */
    public function getFormat()
    {
        return XmlFormat::FORMAT_NAME;
    }

}
