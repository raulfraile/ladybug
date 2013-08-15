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

class SymfonyMetadata extends AbstractMetadata
{

    const ICON = 'symfony2';
    const URL = 'http://api.symfony.com/%version%/index.html?q=%class%';

    public function __construct()
    {
        $this->version = '2.2';

        // determine symfony version
        if (class_exists('Symfony\\Component\\HttpKernel\\Kernel')) {
            $this->version = sprintf('%s.%s', \Symfony\Component\HttpKernel\Kernel::MAJOR_VERSION, \Symfony\Component\HttpKernel\Kernel::MINOR_VERSION);
        }
    }

    public function hasMetadata($id, $type = MetadataInterface::TYPE_CLASS)
    {
        return MetadataInterface::TYPE_CLASS === $type && $this->isNamespace($id, 'Symfony');
    }

    public function getMetadata($id, $type = MetadataInterface::TYPE_CLASS)
    {
        if ($this->hasMetadata($id, $type)) {
            return array(
                'help_link' => $this->generateHelpLinkUrl(self::URL, array(
                    '%version%' => $this->version,
                    '%class%' => urlencode($id)
                )),
                'icon' => self::ICON,
                'version' => $this->version
            );
        }

        return array();
    }

}
