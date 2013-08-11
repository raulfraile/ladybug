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

class CodeType extends BaseType
{

    const TYPE_ID = 'code';

    const MIMETYPE_CSHARP = 'text/x-csharp';
    const MIMETYPE_CSS = 'text/css';
    const MIMETYPE_JAVA = 'text/x-java';
    const MIMETYPE_JAVASCRIPT = 'text/javascript';
    const MIMETYPE_JSON = 'application/json';
    const MIMETYPE_PHP = 'application/x-httpd-php-open';
    const MIMETYPE_SCALA = 'text/x-scala';

    protected $mimetypeMap = array(
        //'text/x-php' => self::MIMETYPE_PHP
    );

    protected $language;

    public function setLanguage($language)
    {
        if (array_key_exists($language, $this->mimetypeMap)) {
            $language = $this->mimetypeMap[$language];
        }

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
