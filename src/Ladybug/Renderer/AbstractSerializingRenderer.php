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

use JMS\Serializer\Serializer;
use Ladybug\Exception\SerializerNotFoundException;

abstract class AbstractSerializingRenderer extends AbstractRenderer
{

    /** @var Serializer $serializer */
    protected $serializer;

    /**
     * Gets serializer
     *
     * @throws \Ladybug\Exception\SerializerNotFoundException
     * @return Serializer
     */
    protected function getSerializer()
    {
        if (is_null($this->serializer)) {
            if (!class_exists('\JMS\Serializer\SerializerBuilder')) {
                throw new SerializerNotFoundException();
            }

            $this->serializer = \JMS\Serializer\SerializerBuilder::create()
                ->addMetadataDir(__DIR__.'/../Resources/serializer/', 'Ladybug\\Type')
                ->build();
        }

        return $this->serializer;
    }

    public function render(array $nodes, array $extraData = array())
    {
        return $this->getSerializer()->serialize($nodes, static::getFormat());
    }

}
