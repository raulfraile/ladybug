<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Processor / AuraMetadata
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Metadata;

use Ladybug\Metadata\MetadataInterface;

class AuraMetadata extends AbstractMetadata
{

    const ICON = 'aura';
    const URL = 'http://auraphp.github.io/Aura.%component%/version/%version%/api/classes/%class%.html';

    public function __construct()
    {
        $this->version = '1.1.0';
    }

    public function hasMetadata($id, $type = MetadataInterface::TYPE_CLASS)
    {
        return MetadataInterface::TYPE_CLASS === $type && $this->isNamespace($id, 'Aura');
    }

    public function getMetadata($id, $type = MetadataInterface::TYPE_CLASS)
    {
        if ($this->hasMetadata($id, $type)) {
            return array(
                'help_link' => $this->generateHelpLinkUrl(self::URL, array(
                    '%version%' => $this->version,
                    '%component%' => $this->getComponent($id),
                    '%class%' => str_replace('\\', '.', $id)
                )),
                'icon' => self::ICON,
                'version' => $this->version
            );
        }

        return array();
    }

    protected function getComponent($class)
    {
        $namespace = explode('\\', $class);

        return $namespace[1];
    }
}
