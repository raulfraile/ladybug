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

class ZendMetadata extends AbstractMetadata
{

    const ICON = 'zend';
    const URL = 'http://framework.zend.com/apidoc/%version%/namespaces/%class%.html';

    public function __construct()
    {
        $this->version = '2.2';
    }

    public function hasMetadata($class)
    {
        return $this->isNamespace($class, 'Zend');
    }

    public function getMetadata($class)
    {
        if ($this->hasMetadata($class)) {
            return array(
                'help_link' => $this->generateHelpLinkUrl(self::URL, array(
                    '%version%' => $this->version,
                    '%class%' => urlencode($class)
                )),
                'icon' => self::ICON
            );
        }

        return array();
    }

}
