<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Type\Exception\InvalidVariableTypeException;

/**
 * String is an abstraction of a primitive variable of type 'string'
 */
class StringType extends AbstractType
{
    const TYPE_ID = 'string';

    /** @var string $encoding */
    protected $encoding;


    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
    }

    /**
     * Get normalized encoding.
     * @param string $encoding
     *
     * @return string
     */
    protected function getNormalizedEncoding($encoding)
    {
        $validEncodings = array(
            'ISO-8859-1', 'ISO8859-1',
            'ISO-8859-5', 'ISO8859-5',
            'ISO-8859-15', 'ISO8859-15',
            'UTF-8',
            'CP866', 'IBM866', '866',
            'CP1251', 'WINDOWS-1251', 'WIN-1251', '1251',
            'CP1252', 'WINDOWS-1252', '1252',
            'KOI8-R', 'KOI8-RU', 'KOI8R',
            'BIG5', '950',
            'GB2312', '936',
            'BIG5-HKSCS',
            'SHIFT_JIS', 'SJIS', 'SJIS-WIN', 'CP932', '932',
            'EUC-JP', 'EUCJP', 'EUCJP-WIN',
            'MACROMAN'
        );

        if (in_array(strtoupper($encoding), $validEncodings)) {
            return $encoding;
        }

        return 'ISO-8859-1';
    }

    /**
     * Get encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @inheritdoc
     */
    public function load($var, $level = 1)
    {
        if (!is_string($var)) {
            throw new InvalidVariableTypeException();
        }

        parent::load($var, $level);

        $this->encoding = mb_detect_encoding($var);
        $this->length = mb_strlen($var, $this->getNormalizedEncoding($this->encoding));
    }

    /**
     * @inheritdoc
     */
    public function getInlineValue()
    {
        return sprintf('"%s"', $this->value);
    }

}
