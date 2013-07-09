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

class SilexMetadata extends AbstractMetadata
{

    const ICON = 'silex';
    const URL = 'http://silex.sensiolabs.org/api/index.html?q=%class%';

    public function __construct()
    {
        $this->version = null;
    }

    public function hasMetadata($class)
    {
        return $this->isNamespace($class, 'Silex');
    }

    public function getMetadata($class)
    {
        return array(
            'help_link' => $this->generateHelpLinkUrl(array(
                '%class%' => urlencode($class)
            )),
            'icon' => self::ICON
        );
    }

}
