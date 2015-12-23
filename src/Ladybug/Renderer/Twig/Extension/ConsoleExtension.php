<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Renderer\Twig\Extension;

class ConsoleExtension extends BaseExtension
{

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ladybug.console';
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array_merge(parent::getFilters(), array(
            new \Twig_SimpleFilter('tags', array($this, 'getTags'), array('is_safe' => array('html'))),
        ));
    }

    public function getTags($text)
    {
        $textTags = str_replace(' ', '<space>', $text);
        $textTags = str_replace("\n", '<intro>', $textTags);
        $textTags = str_replace("\t", '<tab>', $textTags);

        return $textTags;
    }
}
