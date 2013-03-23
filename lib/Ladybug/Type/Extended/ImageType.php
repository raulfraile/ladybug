<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * ExtensionBase class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

use Ladybug\Type\BaseType;
use Pimple;

class ImageType extends BaseType
{

    const TYPE_ID = 'image';

    /**
     * Constructor
     *
     * @param string  $var
     * @param mixed   $level
     * @param Options $options
     */
    public function __construct($var, Pimple $container)
    {
        parent::__construct(self::TYPE_ID, $var, $container);
    }


}
