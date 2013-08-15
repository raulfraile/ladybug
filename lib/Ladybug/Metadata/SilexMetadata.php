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

class SilexMetadata extends AbstractMetadata
{

    const ICON = 'silex';
    const URL = 'http://silex.sensiolabs.org/api/index.html?q=%class%';

    public function __construct()
    {
        $this->version = null;
    }

    public function hasMetadata($id, $type = MetadataInterface::TYPE_CLASS)
    {
        return MetadataInterface::TYPE_CLASS === $type && $this->isNamespace($id, 'Silex');
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
