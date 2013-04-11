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

use Ladybug\Theme\CliThemeInterface;
use Ladybug\Format\FormatInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;


class ConsoleRender extends BaseRender implements RenderInterface
{



    protected $console;

    public function __construct(CliThemeInterface $theme, FormatInterface $format)
    {

        parent::__construct($theme, $format);


        $this->console = new ConsoleOutput();

        // load styles
        foreach ($this->theme->getCliColors() as $key => $item) {
            $style = new OutputFormatterStyle($item);
            $this->console->getFormatter()->setStyle($key, $style);
        }
    }

    public function render(array $nodes)
    {
        $result = $this->twig->render('layout.console.twig', array(
            'nodes' => $nodes
        ));

        $result = preg_replace('/\s/', '', $result);
        $result = str_replace('<intro>', PHP_EOL, $result);
        $result = str_replace('<tab>', '   ', $result);
        $result = str_replace('<space>', ' ', $result);

        $this->console->writeln($result);
    }

    public function getFormat()
    {
        return self::FORMAT_CLI;
    }

}
