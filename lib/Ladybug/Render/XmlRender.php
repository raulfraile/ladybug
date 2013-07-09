<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/AbstractType: Base type
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
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

    public function render(array $nodes)
    {
        $this->load();

        /** @var ThemeInterface $theme */
        $theme = $this->theme;

        $serializer = \JMS\Serializer\SerializerBuilder::create()
            ->addMetadataDir(__DIR__.'/../Config/Serializer/', 'Ladybug\\Type')
            ->build();

        return $serializer->serialize($nodes, 'xml');

    }
}
