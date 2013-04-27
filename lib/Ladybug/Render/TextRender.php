<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/BaseType: Base type
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Ladybug\Theme\ThemeInterface;

class TextRender implements RenderInterface
{

    /** @var ThemeInterface $theme */
    protected $theme;

    protected $console;

    public function __construct(ThemeInterface $theme)
    {

        $this->theme = $theme;

    }

    public function render(array $nodes)
    {
        $result = '';

        foreach ($nodes as $var) {
            $result .= $var->render(null, 'txt');
        }

        $result = preg_replace('/\s/', '', $result);
        $result = str_replace('<intro>', PHP_EOL, $result);
        $result = str_replace('<tab>', '   ', $result);
        $result = str_replace('<space>', ' ', $result);

        return $result;
    }
}
