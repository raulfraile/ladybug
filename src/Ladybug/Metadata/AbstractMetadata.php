<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Metadata;

/**
 * Metadata classes can extend from this class to get some common methods to
 * generate URLs and check namespaces/prefixes.
 */
abstract class AbstractMetadata implements MetadataInterface
{

    const ICON = 'base';
    const URL = '#';

    /** @var string $version */
    protected $version = null;

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
