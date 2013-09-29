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

    /**
     * Checks whether the class has the given namespace.
     * @param string $className Class name
     * @param string $namespace Namespace
     *
     * @return bool Returns TRUE if the class has the namespace
     */
    protected function isNamespace($className, $namespace)
    {
        return preg_match(sprintf('/^%s\\\/', $namespace), $className) === 1;
    }

    /**
     * Checks whether the class has the given prefix.
     * @param string $className Class name
     * @param string $prefix    Prefix
     *
     * @return bool Returns TRUE if the class is prefixed with the given prefix
     */
    protected function isPrefix($className, $prefix)
    {
        return preg_match(sprintf('/^%s/', $prefix), $className) === 1;
    }

}
