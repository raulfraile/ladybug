<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Processor / Standard Object
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Metadata;

use Ladybug\Metadata\MetadataInterface;

class TwigMetadata extends AbstractMetadata
{

    const ICON = 'twig';
    const URL = 'http://twig.sensiolabs.org/api/master/%class%.html';

    public function __construct()
    {
        $this->version = null;
    }

    public function hasMetadata($id, $type = MetadataInterface::TYPE_CLASS)
    {
        return MetadataInterface::TYPE_CLASS === $type && $this->isPrefix($id, 'Twig_');
    }

    public function getMetadata($id, $type = MetadataInterface::TYPE_CLASS)
    {
        if ($this->hasMetadata($id, $type)) {
            return array(
                'help_link' => $this->generateHelpLinkUrl(self::URL, array(
                    '%class%' => urlencode($id)
                )),
                'icon' => self::ICON
            );
        }

        return array();
    }

}
