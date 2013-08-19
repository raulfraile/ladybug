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

use Ladybug\Theme\ThemeInterface;

class XmlRender extends AbstractRender implements RenderInterface
{

    public function getFormat()
    {
        return \Ladybug\Format\XmlFormat::FORMAT_NAME;
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->load();

        $serializer = \JMS\Serializer\SerializerBuilder::create()
            ->addMetadataDir(__DIR__.'/../Config/Serializer/', 'Ladybug\\Type')
            ->build();

        return $serializer->serialize($nodes, 'xml');

    }
}
