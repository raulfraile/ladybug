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

class UnixPermissionsType extends BaseType
{

    const TYPE_ID = 'unix_permissions';

    public function getFormattedValue()
    {
        return $this->data;
    }

    public function getTemplateName()
    {
        return 'unix_permissions';
    }

    public function load($var)
    {
        $this->data = decoct($var);
    }


}
