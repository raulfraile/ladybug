<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Loads Ladybug helpers
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

class Loader
{

    public static function loadHelpers($path = null)
    {
        if (null !== $path) {
            require_once($path);
        } else {
            require_once(__DIR__ . '/helpers.php');
        }
    }
}
