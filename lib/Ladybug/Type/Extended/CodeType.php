<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class CodeType extends AbstractType
{

    const TYPE_ID = 'code';

    const MIMETYPE_CSHARP = 'text/x-csharp';
    const MIMETYPE_CSS = 'text/css';
    const MIMETYPE_JAVA = 'text/x-java';
    const MIMETYPE_JAVASCRIPT = 'text/javascript';
    const MIMETYPE_JSON = 'application/json';
    const MIMETYPE_PHP = 'application/x-httpd-php-open';
    const MIMETYPE_SCALA = 'text/x-scala';

    /** @var string $content */
    protected $content;

    /** @var string $language */
    protected $language;

    /**
     * Sets code content
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Gets code content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets code language
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Gets code language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

}
