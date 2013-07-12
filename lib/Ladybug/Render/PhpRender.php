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

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Ladybug\Format;

class PhpRender extends AbstractRender implements RenderInterface
{

    public function render(array $nodes, array $extraData = array())
    {
        return array_merge(array(
            'nodes' => $nodes
        ), $extraData);
    }

    public function getFormat()
    {
        return Format\PhpFormat::FORMAT_NAME;
    }

}
