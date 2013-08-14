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

class DoctrineMetadata extends AbstractMetadata
{

    const ICON = 'doctrine';

    const URL_ORM = 'http://www.doctrine-project.org/api/orm/%version%/class-%class%.html';
    const URL_DBAL = 'http://www.doctrine-project.org/api/dbal/%version%/class-%class%.html';
    const URL_ODM = 'http://www.doctrine-project.org/api/mongodb_odm/%version%/class-%class%.html';
    const URL_COMMON = 'http://www.doctrine-project.org/api/common/%version%/class-%class%.html';

    public function __construct()
    {
        $this->version = '2.3';
    }

    public function hasMetadata($class)
    {
        return $this->isNamespace($class, 'Doctrine');
    }

    public function getMetadata($class)
    {
        if ($this->hasMetadata($class)) {

            $helpLink = '#';
            if ($this->isNamespace($class, 'Doctrine\\ORM')) {
                $helpLink = $this->generateHelpLinkUrl(self::URL_ORM, array(
                    '%version%' => $this->version,
                    '%class%' => str_replace('\\', '.', $class)
                ));
            } elseif ($this->isNamespace($class, 'Doctrine\\DBAL')) {
                $helpLink = $this->generateHelpLinkUrl(self::URL_DBAL, array(
                    '%version%' => $this->version,
                    '%class%' => str_replace('\\', '.', $class)
                ));
            } elseif ($this->isNamespace($class, 'Doctrine\\ODM')) {
                $helpLink = $this->generateHelpLinkUrl(self::URL_ODM, array(
                    '%version%' => $this->version,
                    '%class%' => str_replace('\\', '.', $class)
                ));
            } elseif ($this->isNamespace($class, 'Doctrine\\Common')) {
                $helpLink = $this->generateHelpLinkUrl(self::URL_ORM, array(
                    '%version%' => $this->version,
                    '%class%' => str_replace('\\', '.', $class)
                ));
            }

            return array(
                'help_link' => $helpLink,
                'icon' => self::ICON,
                'version' => $this->version
            );
        }

        return array();
    }

}
