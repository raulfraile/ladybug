<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Format;

use Ladybug\Format\FormatInterface;

class FormatResolver
{

    /** @var array $formats */
    protected $formats;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formats = array();
    }

    /**
     * Registers a new environment
     *
     * When resolving, this environment is preferred over previously registered ones.
     *
     * @param FormatInterface $format
     * @param string          $key
     */
    public function register(FormatInterface $format, $key)
    {
        $this->formats[$key] = $format;
    }

    /**
     * Resolve theme
     * @param $key
     *
     * @return FormatInterface
     */
    public function getFormat($key)
    {
        return $this->formats['format_'.$key];
    }
}
