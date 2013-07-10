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

class ConsoleRender extends AbstractRender implements RenderInterface
{

    protected $console;

    protected function load()
    {
        if (!$this->isLoaded) {
            parent::load();

            $this->console = new ConsoleOutput();

            // load styles
            foreach ($this->theme->getCliColors() as $key => $item) {
                if (is_array($item)) {
                    $style = new OutputFormatterStyle($item[0], $item[1]);
                } else {
                    $style = new OutputFormatterStyle($item);
                }

                $this->console->getFormatter()->setStyle($key, $style);
            }
        }
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->load();

        $result = $this->twig->render('layout.console.twig', array(
            'nodes' => $nodes
        ));

        $result = preg_replace('/\s/', '', $result);
        $result = str_replace('<intro>', PHP_EOL, $result);
        $result = str_replace('<tab>', '<f_tab> · </f_tab>', $result);
        $result = str_replace('<space>', ' ', $result);

        $this->console->writeln($result);
    }

    public function getFormat()
    {
        return self::FORMAT_CONSOLE;
    }

}
