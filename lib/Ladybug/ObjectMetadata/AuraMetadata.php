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

namespace Ladybug\ObjectMetadata;

class AuraMetadata extends BaseMetadata
{

    const ICON = 'aura';
    const URL = 'http://auraphp.github.io/Aura.%component%/version/%version%/api/classes/%class%.html';

    public function __construct()
    {
        $this->version = '1.1.0';
    }

    public function hasMetadata($class)
    {
        return $this->isNamespace($class, 'Aura');
    }

    public function getMetadata($class)
    {
        return array(
            'help_link' => $this->generateHelpLinkUrl(array(
                '%version%' => $this->version,
                '%component%' => $this->getComponent($class),
                '%class%' => str_replace('\\', '.', $class)
            )),
            'icon' => self::ICON,
            'version' => $this->version
        );
    }

    protected function getComponent($class)
    {
        $namespace = explode('\\', $class);

        return $namespace[1];
    }
}
