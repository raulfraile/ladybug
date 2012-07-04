<?php

/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/TFactory: Types factory
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;
use Ladybug\Exception\InvalidTypeException;

class TFactory
{
    public static function factory($var, $level, Options $options)
    {
        $result = null;

        if ($var === null) {
            $result = new TNull($level, $options);
        } elseif (is_bool($var)) {
            $result = new TBool($var, $level, $options);
        } elseif (is_string($var)) {
            $result = new TString($var, $level, $options);
        } elseif (is_int($var)) {
            $result = new TInt($var, $level, $options);
        } elseif (is_float($var)) {
            $result = new TFloat($var, $level, $options);
        } elseif (is_array($var)) {
            $result = new TArray($var, $level, $options);
        } elseif (is_object($var)) {
            $result = new TObject($var, $level, $options);
        } elseif (is_resource($var)) {
            $result = new TResource($var, $level, $options);
        } else {
            throw new InvalidTypeException();
        }

        return $result;
    }
}
