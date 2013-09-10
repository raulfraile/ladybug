<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Ladybug\Format\TextFormat;

class TextRender extends AbstractTemplatingRender
{

    public function getFormat()
    {
        return TextFormat::FORMAT_NAME;
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->loadTemplatingEngine();

        $result = $this->templatingEngine->render('layout.text.twig', array_merge(
            array(
                'nodes' => $nodes
            ), $extraData
        ));

        $result = preg_replace('/\s/', '', $result);
        $result = str_replace('<intro>', PHP_EOL, $result);
        $result = str_replace('<tab>', '   ', $result);
        $result = str_replace('<space>', ' ', $result);

        return $result;
    }
}
