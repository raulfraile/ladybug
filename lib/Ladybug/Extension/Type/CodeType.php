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

namespace Ladybug\Extension\Type;

class CodeType extends BaseType
{

    const TYPE_ID = 'code';

    protected $language;

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getTemplateName()
    {
        return 'code';
    }

    public function load($var)
    {
        // TODO: Implement load() method.
    }

}
