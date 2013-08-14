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

abstract class AbstractMetadata implements MetadataInterface
{

    const ICON = 'base';
    const URL = '#';

    /** @var string $version */
    protected $version = null;

    abstract public function hasMetadata($class);

    abstract public function getMetadata($class);

    public function generateHelpLinkUrl($url, array $parameters = array())
    {
        return str_replace(array_keys($parameters), array_values($parameters), $url);
    }

    protected function isNamespace($class, $namespace)
    {
        return preg_match(sprintf('/^%s\\\/', $namespace), $class) === 1;
    }

    protected function isPrefix($class, $namespace)
    {
        return preg_match(sprintf('/^%s/', $namespace), $class) === 1;
    }

}
