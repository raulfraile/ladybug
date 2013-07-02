<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/AbstractType: Base type
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Ladybug\Theme\ThemeInterface;
use Ladybug\Format\FormatInterface;

class TextRender extends BaseRender implements RenderInterface
{

    public function getFormat()
    {
        return self::FORMAT_TEXT;
    }

    public function __construct(ThemeInterface $theme, FormatInterface $format)
    {
        parent::__construct($theme, $format);
    }

    public function render(array $nodes)
    {
        $result = $this->twig->render('layout.text.twig', array(
            'nodes' => $nodes
        ));

        $result = preg_replace('/\s/', '', $result);
        $result = str_replace('<intro>', PHP_EOL, $result);
        $result = str_replace('<tab>', '   ', $result);
        $result = str_replace('<space>', ' ', $result);

        return $result;
    }
}
