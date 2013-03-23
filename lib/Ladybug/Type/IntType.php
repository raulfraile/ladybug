<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/IntType variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;
use Twig_Loader_Filesystem;
use Twig_Environment;

class IntType extends BaseType
{

    const TYPE_ID = 'int';

    public function __construct($var, $level, $container)
    {
        parent::__construct(self::TYPE_ID, $var, $level, $container);
    }


}
