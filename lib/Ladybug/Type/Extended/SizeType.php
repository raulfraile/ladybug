<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * AbstractPlugin class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type\Extended;

class SizeType extends BaseType
{

    const TYPE_ID = 'size';

    const UNIT_BYTE = 'bytes';
    const UNIT_KB = 'Kb';
    const UNIT_MB = 'Mb';
    const UNIT_GB = 'Gb';
    const UNIT_TB = 'Tb';

    protected $units = array(
        self::UNIT_BYTE,
        self::UNIT_KB,
        self::UNIT_MB,
        self::UNIT_GB,
        self::UNIT_TB,
    );

    protected $sizes = array();

    protected $unit = self::UNIT_BYTE;

    public function getUnit()
    {
        return $this->unit;
    }

    public function getUnits()
    {
        return $this->units;
    }

    public function getSizes()
    {
        return $this->sizes;
    }

    public function getSizesConverted()
    {
        $sizes = array();

        foreach ($this->sizes as $key => $item) {
            $sizes[$key] = $item * $this->data;
        }

        return $sizes;
    }

    public function getSizeUnit()
    {
        return $this->data / $this->sizes[$this->unit];
    }

    public function getTemplateName()
    {
        return 'size';
    }

    public function load($var, $level = 1)
    {
        $this->sizes[self::UNIT_BYTE] = 1;
        $this->sizes[self::UNIT_KB] = $this->sizes[self::UNIT_BYTE] * 1024;
        $this->sizes[self::UNIT_MB] = $this->sizes[self::UNIT_KB] * 1024;
        $this->sizes[self::UNIT_GB] = $this->sizes[self::UNIT_MB] * 1024;
        $this->sizes[self::UNIT_TB] = $this->sizes[self::UNIT_GB] * 1024;

        $this->data = (float) $var;

        // calculate unit
        if ($this->data < $this->sizes[self::UNIT_MB]) {
            $this->unit = self::UNIT_KB;
        } elseif ($this->data < $this->sizes[self::UNIT_GB]) {
            $this->unit = self::UNIT_MB;
        } else {
            $this->unit = self::UNIT_GB;
        }
    }

}
