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

class ImageType extends AbstractType
{

    const TYPE_ID = 'image';

    /** @var int $width */
    protected $width;

    /** @var int height */
    protected $height;

    /** @var string $tempPath */
    protected $tempPath;

    /** @var string $image */
    protected $image;

    /**
     * Sets image height.
     * @param $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Gets image height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets image width.
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Gets image width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets image content
     * @param $image
     */
    public function setImage($image)
    {
        $this->data = base64_encode($image);

        // create temp file
        $this->tempPath = sys_get_temp_dir() . '/' . uniqid('ladybug_');
        file_put_contents($this->tempPath, $image);
    }

    /**
     * Gets image temporary path.
     *
     * @return string
     */
    public function getTempPath()
    {
        return $this->tempPath;
    }

}
